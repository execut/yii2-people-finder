<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator\comparators;

use execut\peoplesFinder\PeopleInterface;
use execut\peoplesFinder\peoplesComparator\Result;

interface Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo):Result;
}