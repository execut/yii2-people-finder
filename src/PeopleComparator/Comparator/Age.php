<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparator;

use execut\peopleFinder\PeopleComparator\Result;
use execut\peopleFinder\Person\Person;

class Age implements Comparator
{
    public function compare(Person $peopleOne, Person $peopleTwo): Result
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