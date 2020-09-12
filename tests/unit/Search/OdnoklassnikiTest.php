<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\tests\unit\Search;


use Codeception\Test\Unit;
use execut\peopleFinder\Person\Simple;
use execut\peopleFinder\Search\Odnoklassniki;

class OdnoklassnikiTest extends Unit
{
    public function testGetTotalCount() {
        $query = 'Test User';
        $adapter = $this->getAdapterMock($query);
        $client = new Odnoklassniki($query, $adapter);
        $this->assertEquals(123, $client->getTotalCount());
    }

    public function testGetPeople() {
        $query = 'Test User';
        $adapter = $this->getAdapterMock($query, true);
        $client = new Odnoklassniki($query, $adapter);
        $people = $client->current();
        $this->assertInstanceOf(Simple::class, $people);
        $this->assertEquals('123', $people->getId());
        $this->assertEquals($query, $people->getName()->getName());
//        $this->assertEquals(30, $people->getAge());
//        $this->assertEquals('Москва, Россия', $people->getLocation());
    }

//    public function testGetPeopleWithoutAge() {
//        $query = 'Test User';
//        $adapter = $this->getAdapterMock($query, false);
//        $client = new Odnoklassniki($query, $adapter);
//        $people = $client->current();
//        $this->assertInstanceOf(Odnoklassniki\People::class, $people);
//        $this->assertEquals($query, $people->getName());
//        $this->assertNull($people->getAge());
//    }

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

        $adapter = $this->getMockBuilder(Odnoklassniki\Adapter::class)->getMock();
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