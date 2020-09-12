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
    public function __construct(array $equalFriends) {
        $this->equalFriends = $equalFriends;
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
        foreach ($this->equalFriends as $equalFriend) {
            $result .= $equalFriend->getName() . ', ';
        }

        return trim($result, ', ');
    }
}