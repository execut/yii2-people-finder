<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparators;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\PeopleComparator\Result;

interface Comparator
{
    public function compare(Person $peopleOne, Person $peopleTwo):Result;
}