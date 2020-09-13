<?php
/**
 */

namespace execut\peopleFinder\Tests\Unit\PeopleComparator\Comparator;


use Codeception\Test\Unit;
use execut\peopleFinder\Name\Comparator\Comparator;
use execut\peopleFinder\PeopleComparator\Comparator\Name;
use execut\peopleFinder\Person\Simple as SimplePerson;
use \execut\peopleFinder\Name\Simple as SimpleName;

class NameTest extends Unit
{
    public function testCompare()
    {
        $nameA = new SimpleName('тест');
        $nameB = new SimpleName('Тест');
        $namesComparator = $this->getMockBuilder(Comparator::class)->getMock();
        $namesComparator->expects($this->once())
            ->method('compare')
            ->with($nameA, $nameB)
            ->willReturn(100.0);
        $comparator = new Name($namesComparator);
        $peopleOne = new SimplePerson('123', $nameA);
        $peopleTwo = new SimplePerson('456', $nameB);
        $this->assertEquals(100, $comparator->compare($peopleOne, $peopleTwo)->getQuality());
    }
}