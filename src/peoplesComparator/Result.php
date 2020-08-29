<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator;

use execut\peoplesFinder\PeopleInterface;
use execut\peoplesFinder\peoplesComparator\result\RendererInterface;

class Result
{
    protected PeopleInterface $people;
    protected float $quality;
    protected ?RendererInterface $renderer;
    public function __construct(PeopleInterface $people, float $quality, RendererInterface $renderer = null)
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
