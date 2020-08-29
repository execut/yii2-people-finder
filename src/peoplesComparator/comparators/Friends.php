<?php
/**
 */

namespace execut\peoplesFinder\peoplesComparator\comparators;

use execut\peoplesFinder\PeopleInterface;

class Friends implements Comparator
{
    public function compare(PeopleInterface $peopleOne, PeopleInterface $peopleTwo): float
    {
        $peopleTwoFriends = $peopleTwo->getFriends();
        if (count($peopleTwoFriends) == 0) {
            return 0.0;
        }

        $equalFriends = 0;
        $peopleOneFriends = $peopleOne->getFriends();
        if (count($peopleOneFriends) == 0) {
            return 0.0;
        }

        foreach ($peopleOneFriends as $friend) {
            foreach ($peopleTwoFriends as $peopleTwoFriend) {
                if ($friend->isEqual($peopleTwoFriend)) {
                    $equalFriends++;
                }
            }
        }

        $quality = (float) $equalFriends;

        return $quality;
    }
}
