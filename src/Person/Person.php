<?php
/**
 */

namespace execut\peopleFinder\Person;

use execut\peopleFinder\Friends\Friends;
use execut\peopleFinder\Info\Info;
use execut\peopleFinder\Name\Name;

interface Person
{
    public function __construct(string $id, Name $name, Friends $friends = null, Info $info = null);
    public function getFriends():?Friends;
    public function getId():string;
    public function getName():Name;
    public function getInfo():?Info;
}