<?php
/**
 */

namespace execut\peopleFinder;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\PeopleComparator\Comparator\Comparator;

class PeopleComparator
{
    /**
     * @var Person[]
     */
    protected array $peoples;
    protected Person $findedPeople;
    protected Comparator $comparator;
    public function __construct(array $peoples, Person $findedPeople, Comparator $comparator)
    {
        $this->peoples = $peoples;
        $this->findedPeople = $findedPeople;
        $this->comparator = $comparator;
    }

    public function compare()
    {
        $results = [];
        foreach ($this->peoples as $people) {
            $result = $this->comparator->compare($people, $this->findedPeople);
            $results[] = $result;
        }

        return $results;
    }
}