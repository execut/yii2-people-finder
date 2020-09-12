<?php
/**
 */

namespace execut\peopleFinder\Tests\Unit;

use Codeception\Test\Unit;
use execut\peopleFinder\Name\Simple;
use execut\peopleFinder\Person;
use execut\peopleFinder\PeopleComparator;
use execut\peopleFinder\PeopleComparator\Comparators\Comparator;
use execut\peopleFinder\PeopleComparator\Result;

class PeoplesComparatorTest extends Unit
{
    public function testRun()
    {
        $people = new Person\Simple(123, new Simple('Test User'));
        $otherPeople = new Person\Simple(123, new Simple('Other User'));
        $peoples = [
            $people,
            $otherPeople,
        ];
        $findedPeople = new Person\Simple(124, new Simple('Test User'));
        $comparator = $this->getMockBuilder(Comparator::class)->getMock();
        $comparator->expects($this->at(0))
            ->method('compare')
            ->with($people, $findedPeople)
            ->willReturn(new Result($people, 100.0));
        $comparator->expects($this->at(1))
            ->method('compare')
            ->with($otherPeople, $findedPeople)
            ->willReturn(new Result($otherPeople, 0.0));

        $finder = new PeoplesComparator($peoples, $findedPeople, $comparator);
        $results = $finder->compare();
        $this->assertCount(2, $results);
        foreach ($results as $result) {
            $this->assertInstanceOf(Result::class, $result);
            if ($result->getQuality() == 100) {
                $this->assertEquals(spl_object_hash($people), spl_object_hash($result->getPeople()));
            } else {
                $this->assertEquals(0, $result->getQuality());
                $this->assertEquals(spl_object_hash($otherPeople), spl_object_hash($result->getPeople()));
            }
        }
    }
}