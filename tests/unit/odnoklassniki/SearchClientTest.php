<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\odnoklassniki;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\People;
use execut\peoplesFinder\odnoklassniki\SearchClient;
use execut\peoplesFinder\odnoklassniki\searchClient\Adapter;
use yii\helpers\Json;

class SearchClientTest extends Unit
{
    public function testGetTotalCount() {
        $query = 'Test User';
        $adapter = $this->getAdapterMock($query);
        $client = new SearchClient($adapter);
        $client->setQuery($query);
        $this->assertEquals(123, $client->getTotalCount());
    }

    public function testGetPeople() {
        $query = 'Test User';
        $adapter = $this->getAdapterMock($query, true);
        $client = new SearchClient($adapter);
        $client->setQuery($query);
        $people = $client->getPeople();
        $this->assertInstanceOf(People::class, $people);
        $this->assertEquals('123', $people->getId());
        $this->assertEquals($query, $people->getName());
        $this->assertEquals(30, $people->getAge());
        $this->assertEquals('Москва, Россия', $people->getLocation());
    }

    public function testGetPeopleWithoutAge() {
        $query = 'Test User';
        $adapter = $this->getAdapterMock($query, false);
        $client = new SearchClient($adapter);
        $client->setQuery($query);
        $people = $client->getPeople();
        $this->assertInstanceOf(People::class, $people);
        $this->assertEquals($query, $people->getName());
        $this->assertNull($people->getAge());
    }

    /**
     * @param string $query
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getAdapterMock(string $query, $isHasAge = false): \PHPUnit\Framework\MockObject\MockObject
    {
        $info = [
            'uid' => '123',
            'name' => 'Test User',
        ];
        if ($isHasAge) {
            $info['age'] = 30;
        }

        $adapter = $this->getMockBuilder(Adapter::class)->getMock();
        $adapter->expects($this->once())
            ->method('getValues')
            ->with(0, $query, 20)
            ->willReturn([
                'result' => [
                    'users' => [
                        'values' => [
                            'totalCount' => 123,
                            'results' => [
                                0 => [
                                    'user' => [
                                        'info' => $info,
                                        "location" => 'Москва, Россия',
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]);
        return $adapter;
    }
}