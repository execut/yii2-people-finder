<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparators;


use execut\peopleFinder\PeopleComparator\Result;

class Name implements Comparator
{
    public function compare($peopleOne, $peopleTwo):Result
    {
        if ($peopleOne->isEqual($peopleTwo)) {
            $quality = 100.0;
        } else {
            $quality = 0.0;
        }

        return new Result($peopleOne, $quality);
    }
}