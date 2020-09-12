<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparators;


use execut\peopleFinder\PeopleInterface;
use execut\peopleFinder\PeopleComparator\Result;

class Age implements Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo): Result
    {
        $ageOne = $peopleOne->getAge();
        $ageTwo = $peopleTwo->getAge();
        $diff = abs($ageOne - $ageTwo);
        if ($diff > 30) {
            $quality = 0;
        } else {
            $quality = 100 - $diff / 30 * 100;
        }

        $result = new Result($peopleOne, $quality);

        return $result;
    }
}