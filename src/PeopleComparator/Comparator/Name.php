<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparator;


use execut\peopleFinder\PeopleComparator\Result;
use \execut\peopleFinder\Name\Comparator\Comparator as NamesComparator;

class Name implements Comparator
{
    protected NamesComparator $namesComparator;
    public function __construct(NamesComparator $namesComparator)
    {
        $this->namesComparator = $namesComparator;
    }

    public function compare($peopleOne, $peopleTwo):Result
    {
        $nameA = $peopleOne->getName();
        $nameB = $peopleTwo->getName();
        $quality = $this->namesComparator->compare($nameA, $nameB);

        return new Result($peopleOne, $quality);
    }
}