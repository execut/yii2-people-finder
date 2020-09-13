<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparator;

use execut\peopleFinder\PeopleComparator\Result;
use execut\peopleFinder\Person\Person;

class Friends implements Comparator
{
    protected ?\execut\peopleFinder\Name\Comparator\Comparator $nameComparator = null;
    public function compare(Person $peopleOne, Person $peopleTwo): Result
    {
        $peopleOneFriends = $this->extractAllFriends($peopleOne);
        $equalFriends = [];
        $quality = 0.0;
        $twoPeopleFriendsCount = 0;
        if (count($peopleOneFriends) == 0) {
        } else {
            $equalFriendsCount = 0;
            $peopleTwoFriends = $this->extractAllFriends($peopleTwo);
            $twoPeopleFriendsCount = count($peopleTwoFriends);
            if ($peopleTwoFriends) {
                if (count($peopleTwoFriends) == 0) {
                    $quality = 0.0;
                } else {
                    foreach ($peopleOneFriends as $friend) {
                        foreach ($peopleTwoFriends as $peopleTwoFriend) {
                            if ($this->isEqual($friend, $peopleTwoFriend)) {
                                $equalFriends[] = [$friend, $peopleTwoFriend];
                                $equalFriendsCount++;
                            }
                        }
                    }

                    $quality = (float)$equalFriendsCount;
                }
            }
        }

        $result = new Result($peopleOne, $quality, new \execut\peopleFinder\PeopleComparator\Result\Renderer\Friends($equalFriends, $twoPeopleFriendsCount));

        return $result;
    }

    protected function isEqual(Person $personA, Person $personB)
    {
        $comparator = $this->getNameComparator();
        if ($comparator->compare($personA->getName(), $personB->getName()) > 80) {
            return true;
        } else {
            return false;
        }
    }

    protected function extractAllFriends(Person $person)
    {
        $friends = $person->getFriends();
        $result = [];
        if (!$friends) {
            return $result;
        }

        $friends->reset();
        while ($friend = $friends->current()) {
            $result[] = $friend;
            $friends->next();
        }

        return $result;
    }

    /**
     * @return \execut\peopleFinder\Name\Comparator\Comparator
     */
    protected function getNameComparator(): \execut\peopleFinder\Name\Comparator\Comparator
    {
        if ($this->nameComparator !== null) {
            return $this->nameComparator;
        }

        $comparator = new \execut\peopleFinder\Name\Comparator\Comparator();
        return $this->nameComparator = $comparator;
    }
}
