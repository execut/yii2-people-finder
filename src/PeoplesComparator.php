<?php
/**
 */

namespace execut\peoplesFinder;

use execut\peoplesFinder\peoplesComparator\comparators\Comparator;
use execut\peoplesFinder\peoplesComparator\Result;

class PeoplesComparator
{
    /**
     * @var PeopleInterface[]
     */
    protected array $peoples;
    protected PeopleInterface $findedPeople;
    protected Comparator $comparator;
    public function __construct(array $peoples, PeopleInterface $findedPeople, Comparator $comparator)
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
            if ($result > 0) {
                $result = new Result($people, $result);
                $results[] = $result;
            }
        }

        return $results;
    }
}