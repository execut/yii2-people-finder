<?php
/**
 */

namespace execut\peoplesFinder\tests\unit;
use \Codeception\Test\Unit;
use execut\peoplesFinder\Finder;
use execut\peoplesFinder\Result;

class FinderTest extends Unit
{
    public function testFind()
    {
        $finder = new Finder();
        $query = 'Test User';
        $result = $finder->find($query);
        $this->assertInstanceOf(Result::class, $result);
    }
}