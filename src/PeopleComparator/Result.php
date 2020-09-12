<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\PeopleComparator\Result\Renderer;

class Result
{
    protected Person $people;
    protected float $quality;
    protected ?Renderer $renderer;
    public function __construct(Person $people, float $quality, Renderer $renderer = null)
    {
        $this->people = $people;
        $this->quality = $quality;
        $this->renderer = $renderer;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function getPeople() {
        return $this->people;
    }

    public function getRenderer() {
        return $this->renderer;
    }
}
