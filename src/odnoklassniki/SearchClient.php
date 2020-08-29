<?php
namespace execut\peoplesFinder\odnoklassniki;

use execut\peoplesFinder\odnoklassniki\searchClient\Adapter;
use execut\peoplesFinder\PeopleInterface;

class SearchClient
{
    protected string $query;
    protected int $currentPeopleKey = 0;
    /** @var Adapter */
    private $adapter;

    public function __construct(Adapter $adapter = null) {
        if ($adapter === null) {
            $this->adapter = new Adapter();
        } else {
            $this->adapter = $adapter;
        }
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTotalCount()
    {
        $values = $this->getValues();

        return $values['totalCount'];
    }

    /**
     * @return PeopleInterface|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeople() {
        $values = $this->getValues();
        if (empty($values['results'])) {
            return false;
        }

        $results = $values['results'];
        $currentPeopleOnPageKey = $this->getCurrentPeopleOnPageKey();
        if (empty($results[$currentPeopleOnPageKey])) {
            return false;
        }

        $info = $results[$currentPeopleOnPageKey]['user']['info'];
        $name = $info['name'];
        $id = $info['uid'];
        if (empty($info['age'])) {
            $age = null;
        } else {
            $age = $info['age'];
        }

        $people = new People($id, $name, $age, new FriendsClient());

        return $people;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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

    protected function getCurrentPage() {
        return floor($this->getCurrentPeopleKey() / $this->getPageSize());
    }

    protected function getCurrentPeopleOnPageKey() {
        return $this->getCurrentPeopleKey() - $this->getCurrentPage() * $this->getPageSize();
    }
    /**
     * @return int
     */
    protected function getCurrentPeopleKey(): int
    {
        return $this->currentPeopleKey;
    }

    public function setCurrentPeopleKey($key) {
        $this->currentPeopleKey = $key;
    }

    protected function getPageSize() {
        return 20;
    }
}
