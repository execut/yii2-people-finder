<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Search;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\Person\Simple;
use execut\peopleFinder\Vk\Client;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAuthException;
use VK\Exceptions\Api\VKApiPrivateProfileException;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use yii\base\Exception;

class Vk implements Search
{
    protected $query = null;
    protected $currentProfileKey = 0;
    protected ?string $accessToken = null;
    protected ?Client $client = null;
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function next(): bool
    {
        $this->currentProfileKey++;
        return true;
    }

    public function getTotalCount(): int {
        $data = $this->getData();
        return $data['count'];
    }

    public function current():?Person {
        $data = $this->getData();
        if (empty($data['items'][$this->currentProfileKey])) {
            return null;
        }

        $peopleData = $data['items'][$this->currentProfileKey];
        $id = $peopleData['id'];
        $name = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
        if (!empty($peopleData['maiden_name'])) {
            $name .= ' (' . $peopleData['maiden_name'] . ')';
        }
        $location = null;
        if (!empty($peopleData['city'])) {
            $location .= $peopleData['city']['title'];
        }

        if (!empty($peopleData['country'])) {
            if (!empty($peopleData['city'])) {
                $location .= ', ';
            }

            $location .= $peopleData['country']['title'];
        }

        $age = null;
        if (!empty($peopleData['bdate']) && substr_count($peopleData['bdate'], '.') === 2) {
            $format = 'd.m.Y';
            $date = \DateTime::createFromFormat($format, $peopleData['bdate']);
            $age = $date->diff(new \DateTime())->y;
        }

        $people = new Simple($id, new \execut\peopleFinder\Name\Simple($name), new \execut\peopleFinder\Friends\Vk($id), $age);
        return $people;
    }

    protected function getData() {
        $data = $this->getClient()->request([
            'q' => $this->query,
            'count' => 1000,
            'fields' => 'bdate, city, country, maiden_name',
        ], 'users', 'search');
        if ($data['count'] > 1000) {
            $data = $this->extractMoreData($data);
        }

        return $data;
    }

    protected function extractMoreData($data)
    {
        $items = $data['items'];
        $itemsVsId = [];
        foreach ($items as $item) {
            $itemsVsId[$item['id']] = $item;
        }

//        for ($day = 1; $day <= 31; $day++) {
//            $newData = $this->getClient()->request([
//                'q' => $this->query,
//                'count' => 1000,
//                'fields' => 'bdate, city, country, maiden_name',
//                'birth_day' => $day,
//            ], 'users', 'search');
//            foreach ($newData['items'] as $item) {
//                $itemsVsId[$item['id']] = $item;
//            }
//        }

        for ($month = 1; $month <= 12; $month++) {
            $newData = $this->getClient()->request([
                'q' => $this->query,
                'count' => 1000,
                'fields' => 'bdate, city, country, maiden_name',
                'birth_month' => $month,
            ], 'users', 'search');
            foreach ($newData['items'] as $item) {
                $itemsVsId[$item['id']] = $item;
            }
        }

//        for ($year = 1940; $year <= date('Y'); $year++) {
//            $newData = $this->getClient()->request([
//                'q' => $this->query,
//                'count' => 1000,
//                'fields' => 'bdate, city, country, maiden_name',
//                'birth_year' => $year,
//            ], 'users', 'search');
//            foreach ($newData['items'] as $item) {
//                $itemsVsId[$item['id']] = $item;
//            }
//        }
//
//        var_dump($itemsVsId);
//        exit;
        $data['items'] = array_values($itemsVsId);

        return $data;
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
