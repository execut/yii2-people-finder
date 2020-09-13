<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Tests\Unit\Friends;


use Codeception\Test\Unit;
use execut\peopleFinder\Friends\Simple;
use execut\peopleFinder\Person\Person;

class SimpleTest extends Unit
{
    public function testCurrent()
    {
        $personA = $this->getMockBuilder(Person::class)->getMock();
        $friends = new Simple([$personA]);
        $this->assertEquals($personA, $friends->current());
    }

    public function testNext()
    {
        $personA = $this->getMockBuilder(Person::class)->getMock();
        $personB = $this->getMockBuilder(Person::class)->getMock();
        $friends = new Simple([$personA, $personB]);
        $this->assertTrue($friends->next());
        $this->assertEquals($personB, $friends->current());
    }

    public function testGetTotalCount()
    {
        $personA = $this->getMockBuilder(Person::class)->getMock();
        $friends = new Simple([$personA]);
        $this->assertEquals(1, $friends->getTotalCount());
    }

    public function testCurrentWithNull()
    {
        $friends = new Simple([]);
        $this->assertNull($friends->current());
        $this->assertFalse($friends->next());
    }

    public function testReset()
    {
        $personA = $this->getMockBuilder(Person::class)->getMock();
        $personB = $this->getMockBuilder(Person::class)->getMock();
        $friends = new Simple([$personA, $personB]);
        $friends->next();
        $friends->next();
        $friends->reset();
        $this->assertEquals(spl_object_hash($personA), spl_object_hash($friends->current()));
    }
}