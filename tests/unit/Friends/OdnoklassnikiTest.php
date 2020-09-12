<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\peopleFinder\Tests\Unit\Friends;

use Codeception\Test\Unit;
use execut\peopleFinder\Friends\Odnoklassniki\Adapter;
use execut\peopleFinder\Friends\Odnoklassniki;
use execut\peopleFinder\Person\Simple;

class OdnoklassnikiTest extends Unit
{
    public function testGetTotalCount()
    {
        $friends = $this->getObject();
        $this->assertEquals(40, $friends->getTotalCount());
    }

    public function testCurrent()
    {
        $friends = $this->getObject();
        $friend = $friends->current();
        $this->assertInstanceOf(Simple::class, $friend);
        $this->assertEquals('1210', $friend->getId());
        $this->assertInstanceOf(Odnoklassniki::class, $friend->getFriends());
    }

    public function testNext()
    {
        $friends = $this->getObject();
        $this->assertTrue($friends->next());
        $friend = $friends->current();
        $this->assertInstanceOf(Simple::class, $friend);
        $this->assertEquals('1211', $friend->getId());
    }

    protected function getFriendsHtmlStub($page) {
        $rowHtml = file_get_contents(\yii::getAlias('@app/_data/friendsRowAjax.html'));
        $result = '';
        for ($key = 0; $key < 20; $key++) {
            $profileId = '12' . $page . $key;
            $result .= str_replace('{profileId}', $profileId, $rowHtml);
        }

        return $result;
    }

    /**
     * @return Odnoklassniki
     */
    protected function getObject(): Odnoklassniki
    {
        $adapter = $this->getMockBuilder(Adapter::class)->getMock();
        $adapter->expects($this->at(0))
            ->method('getFriendsHtml')
            ->with('123', 1)
            ->willReturn($this->getFriendsHtmlStub(1));
        $adapter->expects($this->at(1))
            ->method('getFriendsHtml')
            ->with('123', 2)
            ->willReturn($this->getFriendsHtmlStub(2));
        $adapter->expects($this->at(2))
            ->method('getFriendsHtml')
            ->with('123', 3)
            ->willReturn('');
        $friends = new Odnoklassniki('123', $adapter);
        return $friends;
    }
}