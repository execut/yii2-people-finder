<?php
/**
 */

namespace execut\peopleFinder\Person;

use execut\peopleFinder\Friends\Friends;
use execut\peopleFinder\Info\Info;
use execut\peopleFinder\Name\Name;

class Simple implements Person
{
    protected ?Friends $friends;
    protected string $id;
    protected Name $name;
    protected ?Info $info;
    public function __construct(string $id, Name $name, Friends $friends = null, Info $info = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->friends = $friends;
        $this->info = $info;
    }

    public function getFriends():?Friends
    {
        return $this->friends;
    }

    public function getId():string
    {
        return $this->id;
    }
    public function getName():Name
    {
        return $this->name;
    }

    public function getInfo():?Info
    {
        return $this->info;
    }
}