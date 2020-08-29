<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\peoplesComparator\comparators;


use Codeception\Test\Unit;
use execut\peoplesFinder\People;
use execut\peoplesFinder\peoplesComparator\comparators\Name;

class NameTest extends Unit
{
    public function testCompareEqual()
    {
        $comparator = new Name();
        $peopleOne = new People('test');
        $peopleTwo = new People('test');
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo));
    }

    public function testCompareNotEqual()
    {
        $comparator = new Name();
        $peopleOne = new People('test');
        $peopleTwo = new People('test2');
        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo));
    }
}