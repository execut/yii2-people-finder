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
    public function testGetPeople() {
        $client = new Vk('Test User');
        $this->assertEquals(681, $client->getTotalCount());
        $people = $client->current();
        $this->assertInstanceOf(Person::class, $people);
        $this->assertEquals('324815480', $people->getId());
        $this->assertEquals('Test User', $people->getName()->getName());
//        $this->assertEquals('Москва, Россия', $people->getLocation());
    }
}