<?php

/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\peoplesFinder;


use execut\peoplesFinder\peoplesComparator\comparators\Age;
use execut\peoplesFinder\peoplesComparator\comparators\Friends;
use execut\peoplesFinder\peoplesComparator\Result;
use yii\base\Exception;

class Report
{
    protected string $targetName;
    protected string $gedcomFile;
    public function __construct(string $targetName, string $gedcomFile) {
        $this->targetName = $targetName;
        $this->gedcomFile = $gedcomFile;
    }

    public function run() {
        $familyPeoples = $this->getFamilyPeoples();
        $targetName = $this->targetName;
        $targetPeople = new People($targetName, $familyPeoples , 2020 - 1994);
        $finder = new Finder();
        $result = $finder->find($targetPeople->getName());
        $findedPeoples = [];
        $totalCount = $result->count();
        if ($totalCount > 2000) {
            throw new Exception('Very big search results count ' . $totalCount);
        }

        for ($key = 0; $key < $totalCount && $key < 2000; $key++) {
            echo 'Parse ' . $key . ' of ' . $totalCount . "\n";
//            try {
                $people = $result->getPeople();
//            } catch (\Exception $e) {
//                break;
//            }
            if (!$people) {
                $result->getPeople();
                if ($totalCount != ($key +1)) {
                    throw new Exception('Too early ended people');
                }
                break;
            }

            if (!empty($findedPeoples[$people->getId()])) {
                throw new Exception('People with id ' . $people->getId() . ' already exists on people key ' . $result->getCurrentPeopleKey());
            }

            if (empty($people->getFriends())) {
                echo 'Empty friends for: https://ok.ru/profile/' . $people->getId() . "\n";
            }

            $findedPeoples[$people->getId()] = $people;
            $result->nextPeople();
        }

        $comparators = [
            new Friends(),
            new Age(),
        ];
        foreach ($comparators as $comparator) {
            echo get_class($comparator) . ' compare' . "\n";
            $peoplesComparator = new PeoplesComparator($findedPeoples, $targetPeople, $comparator);
            /**
             * @var Result[] $results
             */
            $results = $peoplesComparator->compare();
            uasort($results, function ($a, $b) {
                return $a->getQuality() < $b->getQuality();
            });
            foreach ($results as $result) {
                $resultPeople = $result->getPeople();
                $id = $resultPeople->getId();
                $info = '';
                if ($renderer = $result->getRenderer()) {
                    $info .= ';' . $renderer->render();
                }

                echo $result->getQuality() . ';' . $resultPeople->getName() . ';' . $resultPeople->getLocation() . ';' . $id . ';https://ok.ru/profile/' . $id . $info . "\n";
            }
        }
    }

    /**
     * @return array
     */
    protected function getFamilyPeoples(): array
    {
        $gedFile = '/home/execut/Documents/export-BloodTree.ged';


        $parser = new \PhpGedcom\Parser();
        $gedcom = $parser->parse($gedFile);
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
                    $people = new People($firstAndSecondName . ' ' . $surname);
                    $findedPeoples[] = $people;
                }
            }
        }

        return $findedPeoples;
    }
}