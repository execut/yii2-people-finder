<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator;

use execut\peoplesFinder\PeopleInterface;

class Result
{
    protected PeopleInterface $people;
    protected int $quality;
    public function __construct(PeopleInterface $people, int $quality)
    {
        $this->people = $people;
        $this->quality = $quality;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function getPeople() {
        return $this->people;
    }
}
