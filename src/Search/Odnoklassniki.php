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
use execut\peopleFinder\Search\Odnoklassniki\Adapter;

class Odnoklassniki implements Search
{
    protected string $query;
    protected Adapter $adapter;
    protected int $currentPeopleKey = 0;
    public function __construct(string $query, Adapter $adapter)
    {
        $this->query = $query;
        $this->adapter = $adapter;
    }

    public function next():bool
    {
        $this->currentPeopleKey++;
    }

    public function current():?Person
    {
        $values = $this->getValues();
        if (empty($values['results'])) {
            return null;
        }

        $results = $values['results'];
        $currentPeopleOnPageKey = $this->getCurrentPeopleOnPageKey();
        if (empty($results[$currentPeopleOnPageKey])) {
            return null;
        }

        $user = $results[$currentPeopleOnPageKey]['user'];
        $info = $user['info'];
        $name = $info['name'];
        $id = $info['uid'];
        if (empty($info['age'])) {
            $age = null;
        } else {
            $age = $info['age'];
        }

        $location = null;
        if (!empty($user['location'])) {
            $location = $user['location'];
        }

        $people = new Simple($id, new \execut\peopleFinder\Name\Simple($name), new \execut\peopleFinder\Friends\Odnoklassniki($id), $age);

        return $people;
    }

    public function getTotalCount():int
    {
        $values = $this->getValues();

        return (int) $values['totalCount'];
    }

    protected function getValues(): array
    {
        $currentPage = $this->getCurrentPage();
        $query = $this->query;
        $pageSize = $this->getPageSize();
        $firstIndex = $currentPage * $pageSize;

        $data = $this->adapter->getValues($firstIndex, $query, $pageSize);
        $values = $data['result']['users']['values'];
        return $values;
    }

    protected function getCurrentPage():int {
        return floor($this->getCurrentPeopleKey() / $this->getPageSize());
    }

    protected function getCurrentPeopleOnPageKey():int {
        return $this->getCurrentPeopleKey() - $this->getCurrentPage() * $this->getPageSize();
    }
    /**
     * @return int
     */
    protected function getCurrentPeopleKey(): int
    {
        return $this->currentPeopleKey;
    }

    public function setPosition($key) {
        $this->currentPeopleKey = $key;
    }

    protected function getPageSize():int {
        return 20;
    }
}