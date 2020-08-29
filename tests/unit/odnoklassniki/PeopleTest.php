<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\odnoklassniki;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\FriendsClient;
use execut\peoplesFinder\odnoklassniki\People;

class PeopleTest extends Unit
{
    public function testGetFriends() {
        $friendsClient = $this->getMockBuilder(FriendsClient::class)->getMock();
        $profileId = '523759147915';
        $friendsClient
            ->expects($this->once())
            ->method('getFriends')
            ->with($profileId)
            ->willReturn([]);
        $people = new People($profileId, 'Test Test', null, $friendsClient);
        $this->assertIsArray($people->getFriends());
    }
}