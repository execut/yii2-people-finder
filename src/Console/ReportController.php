<?php
/**
 */

namespace execut\peopleFinder\Console;


use execut\peopleFinder\Name\Comparator\Comparator;
use execut\peopleFinder\NamesNormalizer\Normalizer;
use execut\peopleFinder\PeopleComparator\Comparator\Age;
use execut\peopleFinder\PeopleComparator\Comparator\Friends;
use execut\peopleFinder\PeopleComparator\Comparator\Name;
use execut\peopleFinder\Person\Simple;
use execut\peopleFinder\Report\Renderer;
use execut\peopleFinder\Search\Vk;
use yii\base\Exception;
use yii\console\Controller;

class ReportController extends Controller
{
    public function actionIndex($fullname, $gedcomFile) {
        $friendsList = $this->getFamilyPersons($gedcomFile);
        $friends = new \execut\peopleFinder\Friends\Simple($friendsList);
        $person = new Simple('123', new \execut\peopleFinder\Name\Simple($fullname), $friends);
        $name = $person->getName();
        if ($name->getSurname() === null) {
            throw new Exception('Surname is required');
        }
        $search = new Vk($name->getFirstname() . ' ' . $name->getSurname());
        $results = [];
        do {
            $searchedPerson = $search->current();
            if (!$searchedPerson) {
                break;
            }

            $results[] = $searchedPerson;
            $search->next();
        } while($search->current());
        if (empty($results)) {
            if ($name->getSurnameAtBirth()) {
                $search = new Vk($name->getFirstname() . ' ' . $name->getSurnameAtBirth());
                do {
                    $searchedPerson = $search->current();
                    if (!$searchedPerson) {
                        break;
                    }

                    $results[] = $searchedPerson;
                    $search->next();
                } while ($search->current());
            }
        }

        $report = new Renderer($person, $results, [new Name(new Comparator()), new Friends()]);
        $report->render();
    }

    public function actionFindUndefinedNames($gedcomFile)
    {
        $persons = $this->getFamilyPersons($gedcomFile);
        $normalizer = new Normalizer();
        foreach ($persons as $person) {
            $name = $person->getName()->getFirstname();
            if (null === $normalizer->normalize($name)) {
                echo $name . "\n";
            }
        }
    }

    /**
     * @return array
     */
    protected function getFamilyPersons($gedcomFile): array
    {
        $parser = new \PhpGedcom\Parser();
        $gedcom = $parser->parse($gedcomFile);
        $findedPeoples = [];
        foreach ($gedcom->getIndi() as $individual) {
            $name = current($individual->getName());
            if ($name) {
                $name = $name->getName();
                $parts = explode('/', $name);
                if (empty($parts[1])) {
                    continue;
                }

                $firstAndSecondName = trim($parts[0]);
                $surname = trim($parts[1]);
                if (!empty($firstAndSecondName) && !empty($surname) && $firstAndSecondName !== '-' && $surname !== '-' && $firstAndSecondName !== '?' && $surname !== '?') {
                    $fullName = $firstAndSecondName . ' ' . $surname;
                    $people = new Simple($fullName, new \execut\peopleFinder\Name\Simple($fullName));
                    $findedPeoples[] = $people;
                }
            }
        }

        return $findedPeoples;
    }
}