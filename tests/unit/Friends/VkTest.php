<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Tests\Unit\Friends;


use Codeception\Test\Unit;
use execut\peopleFinder\Friends\Vk;
use execut\peopleFinder\Person\Simple;

class VkTest extends Unit
{
    public function testGetTotalCount()
    {
        $friends = new Vk('2314852');
        $this->assertEquals(989, $friends->getTotalCount());
    }

    public function testCurrent()
    {
        $friends = new Vk('2314852');
        $friend = $friends->current();
        $this->assertInstanceOf(Simple::class, $friend);
        $this->assertEquals('14', $friend->getId());
        $this->assertInstanceOf(Vk::class, $friend->getFriends());
    }

    public function testNext()
    {
        $friends = new Vk('2314852');
        $this->assertTrue($friends->next());
        $friend = $friends->current();
        $this->assertInstanceOf(Simple::class, $friend);
        $this->assertEquals('21', $friend->getId());
    }

    public function testSurnameAtBirth()
    {
        $friends = new Vk('2314852');
        for ($key = 0; $key < 100; $key++) {
            $this->assertTrue($friends->next());
            $friend = $friends->current();
            if ($friend->getId() === '5472') {
                break;
            }
        }

        $this->assertInstanceOf(Simple::class, $friend);
        $this->assertEquals('5472', $friend->getId());
        $this->assertEquals('Винокурова', $friend->getName()->getSurnameAtBirth());
    }
}