<?php
/**
 */

namespace execut\peoplesFinder\odnoklassniki;


use execut\peoplesFinder\odnoklassniki\friendsClient\Adapter;

class FriendsClient
{
    protected Adapter $adapter;

    public function __construct(Adapter $adapter = null)
    {
        if ($adapter === null) {
            $this->adapter = new Adapter();
        } else {
            $this->adapter = $adapter;
        }
    }

    public function getFriends($peopleId) {
        $friends = [];
        for ($pageNbr = 1; $pageNbr < 10; $pageNbr++) {
            $html = $this->adapter->getFriendsHtml($peopleId, $pageNbr);
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
                $friend = new People($idNode, $name, null, $this);
                $friends[$idNode] = $friend;
            }
        }

        return $friends;
    }
}