<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Friends;


use execut\peopleFinder\Friends\Odnoklassniki\Adapter;
use execut\peopleFinder\Person\Person;
use\execut\peopleFinder\Name;
use execut\peopleFinder\Person\Simple;

class Odnoklassniki implements Friends
{
    protected int $id;
    protected ?Adapter $adapter;
    protected ?array $friendsData = null;
    protected $position = 0;
    public function __construct(int $ownerId, Adapter $adapter = null)
    {
        $this->id = $ownerId;
        $this->adapter = $adapter;
    }


    public function reset()
    {
        $this->position = 0;
    }

    public function next():bool
    {
        $this->getFriends();
        if ($this->position === count($this->friendsData) - 1) {
            return false;
        }

        $this->position++;
        return true;
    }

    public function current(): ?Person
    {
        $friends = $this->getFriends();

        return $friends[$this->position];
    }

    public function getTotalCount():int
    {
        $friends = $this->getFriends();

        return count($friends);
    }

    public function getFriends() {
        if ($this->friendsData === null) {
            $friends = [];
            for ($pageNbr = 1; $pageNbr < 10; $pageNbr++) {
                $html = $this->adapter->getFriendsHtml($this->id, $pageNbr);
                if (empty($html)) {
                    break;
                }

                $dom = new \DOMDocument('1.0', 'UTF-8');
                @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
                $xpathDom = new \DOMXPath($dom);
                $friendsNodes = $xpathDom->query('*//div[@class="ugrid_i"]');
                for ($key = 0; $key < $friendsNodes->length; $key++) {
                    $friendNode = $friendsNodes->item($key);
                    $friendsNamesNode = $xpathDom->query('*//div[@class="caption"]/div/a', $friendNode)->item(0);
                    $idNode = $xpathDom->query('div', $friendNode)->item(0)->getAttribute('data-entity-id');
                    $name = $friendsNamesNode->textContent;
                    $friend = new Simple($idNode, new Name\Simple($name), new self($idNode, $this->adapter));
                    $friends[] = $friend;
                }
            }

            $this->friendsData = $friends;
        }

        return $this->friendsData;
    }
}