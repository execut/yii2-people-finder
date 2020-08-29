<?php
/**
 */

namespace execut\peoplesFinder\tests\unit\odnoklassniki\friendsClient;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\friendsClient\Adapter;

class AdapterTest extends Unit
{
    public function testGetFriendsHtml() {
        $adapter = new Adapter(false);
        $html = $adapter->getFriendsHtml(523759147915, 2, 0);
        $this->assertNotEmpty($html);
        $this->assertStringContainsString('Артем Насенюк', $html);
    }
}