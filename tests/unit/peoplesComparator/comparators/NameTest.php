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
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
    }

    public function testCompareNotEqual()
    {
        $comparator = new Name();
        $peopleOne = new People('test');
        $peopleTwo = new People('test2');
        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
    }

    public function testCompareEqualWithFamily()
    {
        $comparator = new Name();
        $peopleOne = new People('Test Name');
        $peopleTwo = new People('Test Name');
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
        $peopleOne = new People('Test Name');
        $peopleTwo = new People('Test Other');
        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
        $peopleOne = new People('Other Name');
        $peopleTwo = new People('Test Name');
        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
        $peopleOne = new People('Name');
        $peopleTwo = new People('Test Name');
        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
    }

    public function testCompareEqualWithSecondname()
    {
        $comparator = new Name();
        $peopleOne = new People('Test Second Name');
        $peopleTwo = new People('Test Name');
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
        $comparator = new Name();
        $peopleOne = new People('Test Name');
        $peopleTwo = new People('Test Second Name');
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
//        $comparator = new Name();
//        $peopleOne = new People('Test Third Name');
//        $peopleTwo = new People('Test Second Name');
//        $this->assertEquals(0, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
    }
}