<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\odnoklassniki;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\FriendsClient;
use execut\peoplesFinder\odnoklassniki\friendsClient\Adapter;
use execut\peoplesFinder\odnoklassniki\People;

class FriendsClientTest extends Unit
{
    public function testGetFriendsReal() {
        $client = new FriendsClient();
        $friends = $client->getFriends('579385266820');
        $this->assertCount(153, $friends);
    }

    public function testGetFriendsStubbed() {
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
        $client = new FriendsClient($adapter);
        $friends = $client->getFriends('123');
        $this->assertCount(40, $friends);
        $friend = current($friends);
        $this->assertInstanceOf(People::class, $friend);
        $this->assertEquals('1210', $friend->getId());
        $this->assertEquals('Test User', $friend->getName());
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
}