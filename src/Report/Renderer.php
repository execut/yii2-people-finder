<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Report;


use execut\peopleFinder\PeopleComparator\Comparator\Comparator;
use execut\peopleFinder\PeopleComparator\Result;
use execut\peopleFinder\Person\Person;

class Renderer
{
    protected Person $lookingPerson;
    /**
     * @var Person[]
     */
    protected array $comparedPeople;
    /**
     * @var Comparator[]
     */
    protected array $comparators;

    public function __construct(Person $lookingPerson, array $comparedPeople, array $comparators)
    {
        $this->lookingPerson = $lookingPerson;
        $this->comparedPeople = $comparedPeople;
        $this->comparators = $comparators;
    }

    public function render()
    {
        $comparatorNames = [];
        foreach ($this->comparators as $comparator) {
            $comparatorNames[] = $this->getComparatorName($comparator);
        }

        echo 'Id;Name;' . implode(';', $comparatorNames) . ";\n";
        foreach ($this->comparedPeople as $comparedPeople) {
            $comparatorsQuality = [];
            $resultRenderer = '';
            foreach ($this->comparators as $comparator) {
                $result = $comparator->compare($this->lookingPerson, $comparedPeople);
                $comparatorsQuality[] = $result->getQuality();
                if ($renderer = $result->getRenderer()) {
                    $resultRenderer .= $renderer->render();
                }
            }

            echo $comparedPeople->getId() . ';' . $comparedPeople->getName()->getName() . ';' . implode(';', $comparatorsQuality) . ';' . $resultRenderer . "\n";
        }
    }

    protected function getComparatorName(Comparator $comparator):string
    {
        $classParts = explode('\\', get_class($comparator));

        return $classParts[count($classParts) - 1];
    }
}