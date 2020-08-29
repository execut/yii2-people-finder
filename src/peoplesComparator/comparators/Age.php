<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator\comparators;


use execut\peoplesFinder\PeopleInterface;

class Age implements Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo): float
    {
        $ageOne = $peopleOne->getAge();
        $ageTwo = $peopleTwo->getAge();
        $diff = abs($ageOne - $ageTwo);
        if ($diff > 30) {
            return 0;
        }

        return 100 - $diff / 30 * 100;
    }
}