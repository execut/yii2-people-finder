<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\tests\unit\Search;


use Codeception\Test\Unit;
use execut\peopleFinder\Person\Person;
use execut\peopleFinder\Search\Vk;

class VkTest extends Unit
{
    public function testGetPeople()
    {
        $client = new Vk('Настя Ли (Комарова)');
        $this->assertEquals(1, $client->getTotalCount());
        $people = $client->current();
        $this->assertInstanceOf(Person::class, $people);
        $this->assertEquals('27775445', $people->getId());
        $this->assertEquals('Настя Ли (Комарова)', $people->getName()->getName());
        $this->assertEquals(29, $people->getAge());
        $this->assertInstanceOf(\execut\peopleFinder\Friends\Vk::class, $people->getFriends());
//        $this->assertEquals('Москва, Россия', $people->getLocation());
    }

    public function testGetPeopleWhenMore1000()
    {
        $client = new Vk('Татьяна Колесникова');
        $this->assertGreaterThan(6000, $client->getTotalCount());
    }
}