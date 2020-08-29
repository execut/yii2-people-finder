<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator\comparators;

use execut\peoplesFinder\PeopleInterface;

interface Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo):float;
}