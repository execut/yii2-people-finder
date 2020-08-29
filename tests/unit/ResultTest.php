<?php
/**
 */

namespace execut\peoplesFinder\tests\unit;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\SearchClient;
use execut\peoplesFinder\Result;

class ResultTest extends Unit
{
    public function testGetCount() {
        $client = $this->getMockBuilder(SearchClient::class)->getMock();
        $count = 100;
        $client->method('getTotalCount')
            ->willReturn($count);
        $result = new Result('Test User', $client);
        $this->assertEquals($count, $result->count());
    }

    public function testGetPeople() {
        $client = $this->getMockBuilder(SearchClient::class)->getMock();
        $client->method('getPeople')
            ->willReturn(false);
        $result = new Result('Test User', $client);
        $people = $result->getPeople();
        $this->assertFalse($people);
    }

    public function testNextPeople() {
        $client = $this->getMockBuilder(SearchClient::class)->getMock();
        $client->method('getPeople')
            ->willReturn(false);
        $client->expects($this->once())
            ->method('setCurrentPeopleKey')
            ->with(1);
        $result = new Result('Test User', $client);
        $this->assertTrue($result->nextPeople());
        $this->assertFalse($result->getPeople());
    }

    public function testSetCurrentPeopleKey() {
        $client = $this->getMockBuilder(SearchClient::class)->getMock();
        $client->method('getPeople')
            ->willReturn(false);
        $client->expects($this->once())
            ->method('setCurrentPeopleKey')
            ->with(1);
        $result = new Result('Test User', $client);
        $result->setCurrentPeopleKey(1);
        $this->assertFalse($result->getPeople());
    }
}