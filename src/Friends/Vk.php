<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Friends;


use execut\peopleFinder\Person\Person;
use execut\peopleFinder\Vk\Client;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAuthException;
use VK\Exceptions\Api\VKApiPrivateProfileException;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use yii\base\Exception;

class Vk implements Friends
{
    protected int $id;
    protected ?array $friendsData = null;
    protected $position = 0;
    protected ?Client $client = null;

    public function __construct(int $ownerId)
    {
        $this->id = $ownerId;
    }


    public function reset()
    {
        $this->position = 0;
    }

    public function next(): bool
    {
        $this->getFriends();

        $this->position++;
        return true;
    }

    public function current(): ?Person
    {
        $friends = $this->getFriends();
        if (empty($friends[$this->position])) {
            return null;
        }

        return $friends[$this->position];
    }

    public function getTotalCount(): int
    {
        $friends = $this->getFriends();

        return count($friends);
    }

    public function getFriends()
    {
        if ($this->friendsData === null) {
            $friends = [];
            $data = $this->getData();
            if (!empty($data['items'])) {
                foreach ($data['items'] as $personData) {
                    $name = $personData['first_name'] . ' ' . $personData['last_name'];
                    if (!empty($personData['maiden_name'])) {
                        $name .= ' (' . $personData['maiden_name'] . ')';
                    }

                    $id = $personData['id'];
                    $friend = new \execut\peopleFinder\Person\Simple($id, new \execut\peopleFinder\Name\Simple($name), new self($id));
                    $friends[] = $friend;
                }
            }

            $this->friendsData = $friends;
        }

        return $this->friendsData;
    }

    protected static $cache = [];

    protected function getData()
    {
        $result = $this->getClient()->request([
            'user_id' => $this->id,
            'count' => 1000,
            'fields' => 'maiden_name',
        ], 'friends', 'search');

        return $result;
    }



    protected function getClient()
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $client = new Client();

        return $this->client = $client;
    }
}