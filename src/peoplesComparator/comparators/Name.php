<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator\comparators;


class Name implements Comparator
{
    public function compare($peopleOne, $peopleTwo):float
    {
        if ($peopleOne->isEqual($peopleTwo)) {
            return 100.0;
        } else {
            return 0.0;
        }
    }
}