<?php
/**
 */
namespace execut\peopleFinder\Tests\Unit\PeopleComparator\Comparator;


use Codeception\Test\Unit;
use execut\peopleFinder\PeopleComparator\Comparator\Age;
use execut\peopleFinder\PeopleComparator\Result;
use execut\peopleFinder\Person\Person;

class AgeTest extends Unit
{
    public function testCompare() {
        $comparator = new Age();

        $personA = $this->getMockBuilder(Person::class)->getMock();
        $personA->method('getAge')
            ->willReturn(30);
        $personB = $this->getMockBuilder(Person::class)->getMock();
        $personB->method('getAge')
            ->willReturn(50);
        $result = $comparator->compare($personA, $personB);
        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(33.333333333333, $result->getQuality());
    }

    public function testCompareWithDiffMoreThan30() {
        $comparator = new Age();

        $personA = $this->getMockBuilder(Person::class)->getMock();
        $personA->method('getAge')
            ->willReturn(30);
        $peopleB = $this->getMockBuilder(Person::class)->getMock();
        $peopleB->method('getAge')
            ->willReturn(61);
        $result = $comparator->compare($personA, $peopleB);
        $this->assertEquals(0.0, $result->getQuality());
    }
}