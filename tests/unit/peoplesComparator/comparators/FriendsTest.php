<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\peoplesComparator\comparators;


use Codeception\Test\Unit;
use execut\peoplesFinder\People;
use execut\peoplesFinder\peoplesComparator\comparators\Friends;

class FriendsTest extends Unit
{
    public function testCompare() {
        $comparator = new Friends();

        $peopleOne = new People('test', [
            new People('First Friend'),
            new People('Second Friend'),
            new People('Not Friend'),
        ]);
        $peopleTwo = new People('test', [
            new People('First Friend'),
            new People('Second Friend'),
        ]);
        $result = $comparator->compare($peopleOne, $peopleTwo);
        $this->assertEquals(2, $result->getQuality());
        $renderer = $result->getRenderer();
        $this->assertInstanceOf(\execut\peoplesFinder\peoplesComparator\result\renderer\Friends::class, $renderer);
        $this->assertCount(2, $renderer->getEqualFriends());
    }

    public function testCompareWithoutFriends() {
        $comparator = new Friends();

        $peopleOne = new People('test', []);
        $peopleTwo = new People('test', []);
        $result = $comparator->compare($peopleOne, $peopleTwo);
        $this->assertEquals(0.0, $result->getQuality());
    }
}