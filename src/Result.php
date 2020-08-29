<?php
/**
 */

namespace execut\peoplesFinder;


use execut\peoplesFinder\odnoklassniki\SearchClient;

class Result
{
    protected $currentPeopleKey = 0;
    protected string $query;
    protected SearchClient $client;
    public function __construct(string $query, SearchClient $client = null)
    {
        if ($client === null) {
            $this->client = new SearchClient();
        } else {
            $this->client = $client;
        }

        $this->query = $query;
    }

    public function count() {
        return $this->getClient()->getTotalCount();
    }

    public function nextPeople() {
        $this->currentPeopleKey++;

        return true;
    }

    public function setCurrentPeopleKey($key) {
        $this->currentPeopleKey = $key;
    }

    /**
     * @return int
     */
    public function getCurrentPeopleKey(): int
    {
        return $this->currentPeopleKey;
    }

    public function getPeople() {
        return $this->getClient()->getPeople();
    }

    protected function getClient() {
        $searchClient = $this->client;
        $searchClient->setCurrentPeopleKey($this->getCurrentPeopleKey());
        $searchClient->setQuery($this->query);
        return $searchClient;
    }
}