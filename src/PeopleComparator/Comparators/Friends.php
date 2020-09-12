<?php
/**
 */

namespace execut\peopleFinder\PeopleComparator\Comparators;

use execut\peopleFinder\PeopleInterface;
use execut\peopleFinder\PeopleComparator\Result;

class Friends implements Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo): Result
    {
        $peopleTwoFriends = $peopleTwo->getFriends();
        $equalFriends = [];
        if (count($peopleTwoFriends) == 0) {
            $quality = 0.0;
        } else {
            $equalFriendsCount = 0;
            $peopleOneFriends = $peopleOne->getFriends();
            if (count($peopleOneFriends) == 0) {
                $quality = 0.0;
            } else {
                foreach ($peopleOneFriends as $friend) {
                    foreach ($peopleTwoFriends as $peopleTwoFriend) {
                        if ($friend->isEqual($peopleTwoFriend)) {
                            $equalFriends[] = $friend;
                            $equalFriendsCount++;
                        }
                    }
                }

                $quality = (float)$equalFriendsCount;
            }
        }

        $result = new Result($peopleOne, $quality, new \execut\peopleFinder\PeopleComparator\Result\Renderer\Friends($equalFriends));

        return $result;
    }
}
