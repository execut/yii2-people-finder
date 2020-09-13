<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\PeopleComparator\Result\Renderer;

class Result
{
    protected Person $person;
    protected float $quality;
    protected ?Renderer $renderer;
    public function __construct(Person $person, float $quality, Renderer $renderer = null)
    {
        $this->person = $person;
        $this->quality = $quality;
        $this->renderer = $renderer;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function getPerson() {
        return $this->person;
    }

    public function getRenderer() {
        return $this->renderer;
    }
}
