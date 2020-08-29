<?php
/**
 */

namespace execut\peoplesFinder\tests\unit;

use Codeception\Test\Unit;
use execut\peoplesFinder\People;
use execut\peoplesFinder\PeoplesComparator;
use execut\peoplesFinder\peoplesComparator\comparators\Comparator;
use execut\peoplesFinder\peoplesComparator\Result;

class PeoplesComparatorTest extends Unit
{
    public function testRun()
    {
        $people = new People('Test User');
        $otherPeople = new People('Other User');
        $peoples = [
            $people,
            $otherPeople,
        ];
        $findedPeople = new People('Test User');
        $comparator = $this->getMockBuilder(Comparator::class)->getMock();
        $comparator->expects($this->at(0))
            ->method('compare')
            ->with($people, $findedPeople)
            ->willReturn(100.0);
        $comparator->expects($this->at(1))
            ->method('compare')
            ->with($otherPeople, $findedPeople)
            ->willReturn(0.0);

        $finder = new PeoplesComparator($peoples, $findedPeople, $comparator);
        $results = $finder->compare();
        $this->assertCount(1, $results);
        foreach ($results as $result) {
            $this->assertInstanceOf(Result::class, $result);
            $this->assertEquals(100, $result->getQuality());
            $this->assertEquals(spl_object_hash($people), spl_object_hash($result->getPeople()));
        }
    }
}