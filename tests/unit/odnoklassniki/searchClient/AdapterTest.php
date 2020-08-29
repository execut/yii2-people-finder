<?php
/**
 */

namespace unit\client\searchClient;


use Codeception\Test\Unit;
use execut\peoplesFinder\odnoklassniki\searchClient\Adapter;

class AdapterTest extends Unit
{
    public function testGetValues() {
        $adapter = new Adapter(false);
        $values = $adapter->getValues(0, 'Test User', 20);
        $this->assertIsArray($values);
        $this->assertArrayHasKey('success', $values);
        $this->assertTrue($values['success']);
    }
}