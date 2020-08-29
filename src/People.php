<?php
/**
 */

namespace execut\peoplesFinder;


use execut\peoplesFinder\people\Info;

class People extends PeopleAbstract
{
    protected string $name;
    protected ?Info $info;
    protected ?int $age;
    protected $id = null;
    /**
     * @var PeopleInterface[]
     */
    protected array $friends;
    public function __construct(string $name, array $friends = [], int $age = null, $id = null) {
        $this->name = $name;
        $this->age = $age;
        $this->friends = $friends;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAge():?int {
        return $this->age;
    }

    public function getFriends():array {
        return $this->friends;
    }

    public function getName() {
        return $this->name;
    }
}