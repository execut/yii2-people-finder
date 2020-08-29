<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\peoplesComparator\comparators;


use Codeception\Test\Unit;
use execut\peoplesFinder\People;
use execut\peoplesFinder\peoplesComparator\comparators\Age;
use execut\peoplesFinder\peoplesComparator\Result;

class AgeTest extends Unit
{
    public function testCompare() {
        $comparator = new Age();

        $peopleOne = new People('test', [], 30);
        $peopleTwo = new People('test', [], 50);
        $result = $comparator->compare($peopleOne, $peopleTwo);
        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(33.333333333333, $result->getQuality());
    }

    public function testCompareWithDiffMoreThan30() {
        $comparator = new Age();

        $peopleOne = new People('test', [], 30);
        $peopleTwo = new People('test', [], 61);
        $result = $comparator->compare($peopleOne, $peopleTwo);
        $this->assertEquals(0.0, $result->getQuality());
    }
}