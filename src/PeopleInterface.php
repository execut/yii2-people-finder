<?php
/**
 */

namespace execut\peoplesFinder;

interface PeopleInterface
{
    public function getFriends():array;
    public function getId();
    public function getName();
    public function getFirstName();
    public function getHusbandName();
    public function getSurname();
    public function isEqual(self $people):bool;
    public function getAge():?int;
    public function getLocation():?string;
}