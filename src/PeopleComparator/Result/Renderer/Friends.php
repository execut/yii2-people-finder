<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\PeopleComparator\Result\Renderer;


use execut\peopleFinder\PeopleComparator\Result\Renderer;

class Friends implements Renderer
{
    protected $equalFriends = [];
    protected int $peopleFrieldsCount;
    public function __construct(array $equalFriends, int $peopleFriendsCount) {
        $this->equalFriends = $equalFriends;
        $this->peopleFrieldsCount = $peopleFriendsCount;
    }

    /**
     * @return array
     */
    public function getEqualFriends(): array
    {
        return $this->equalFriends;
    }

    public function render()
    {
        $result = '';
        foreach ($this->equalFriends as $equalFriendPair) {
            $result .= $equalFriendPair[0]->getName()->getName() . '/' . $equalFriendPair[1]->getName()->getName() . ', ';
        }

        return trim($result, ', ') . '. Total friends: ' . $this->peopleFrieldsCount;
    }
}