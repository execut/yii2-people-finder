<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\tests\unit\Person;


use Codeception\Test\Unit;
use execut\peopleFinder\Friends\Friends;
use execut\peopleFinder\Info\Info;
use execut\peopleFinder\Name\Name;
use execut\peopleFinder\Person;

class SimpleTest extends Unit
{
    public function testGetId()
    {
        $name = $this->getMockBuilder(Name::class)->getMock();
        $friends = $this->getMockBuilder(Friends::class)->getMock();
        $info = $this->getMockBuilder(Info::class)->getMock();
        $people = new Person\Simple(123, $name, $friends, $info);

        $this->assertEquals(123, $people->getId());
        $this->assertEquals($name, $people->getName());
        $this->assertEquals($friends, $people->getFriends());
        $this->assertEquals($info, $people->getInfo());
    }
}