<?php
/**
 */

namespace execut\peopleFinder\Tests\Unit\PeopleComparator\Comparator;


use Codeception\Test\Unit;
use execut\peopleFinder\PeopleComparator\Comparator\Friends;
use execut\peopleFinder\Person\Person;
use execut\peopleFinder\Person\Simple;

class FriendsTest extends Unit
{
    public function testCompare() {
        $comparator = new Friends();


        $friendsPersonOne = new \execut\peopleFinder\Friends\Simple([
            new Simple('123', new \execut\peopleFinder\Name\Simple('FirstFirstFirstFirst Friend')),
            new Simple('456', new \execut\peopleFinder\Name\Simple('SecondSecondSecondSecond Friend')),
        ]);
        $personOne = $this->getMockBuilder(Person::class)->getMock();
        $personOne->method('getFriends')
            ->willReturn($friendsPersonOne);

        $friendsPersonTwo =  new \execut\peopleFinder\Friends\Simple([
            new Simple('123', new \execut\peopleFinder\Name\Simple('FirstFirstFirstFirst Friend')),
            new Simple('456', new \execut\peopleFinder\Name\Simple('SecondSecondSecondSecond Friend')),
            new Simple('789', new \execut\peopleFinder\Name\Simple('ThirdThirdThirdThird Friend')),
        ]);

        $personTwo = $this->getMockBuilder(Person::class)->getMock();
        $personTwo->method('getFriends')
            ->willReturn($friendsPersonTwo);

        $result = $comparator->compare($personOne, $personTwo);
        $this->assertEquals(2, $result->getQuality());
        $renderer = $result->getRenderer();
        $this->assertInstanceOf(\execut\peopleFinder\PeopleComparator\Result\Renderer\Friends::class, $renderer);
        $this->assertCount(2, $renderer->getEqualFriends());
    }

    public function testCompareWithoutFriends() {
        $comparator = new Friends();

        $friendsPersonOne = new \execut\peopleFinder\Friends\Simple([]);
        $personA = $this->getMockBuilder(Person::class)->getMock();
        $personA->method('getFriends')
            ->willReturn($friendsPersonOne);
        $personB = $this->getMockBuilder(Person::class)->getMock();
        $personB->method('getFriends')
            ->willReturn($friendsPersonOne);

        $result = $comparator->compare($personA, $personB);
        $this->assertEquals(0.0, $result->getQuality());
    }
}