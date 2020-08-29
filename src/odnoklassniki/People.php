<?php
/**
 */

namespace execut\peoplesFinder\odnoklassniki;

use execut\peoplesFinder\PeopleAbstract;

class People extends PeopleAbstract
{
    protected string $id;
    protected string $name;
    protected FriendsClient $friendsClient;
    protected $age = null;
    public function __construct(string $id, string $name, int $age = null, FriendsClient $friendsClient) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->friendsClient = $friendsClient;
    }

    public function getId() {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @return self[]
     */
    public function getFriends():array {
        return $this->friendsClient->getFriends($this->id);
    }
}