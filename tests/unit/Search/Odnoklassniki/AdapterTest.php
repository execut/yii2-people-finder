<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\tests\unit\Search\Odnoklassniki;


use Codeception\Test\Unit;
use execut\peopleFinder\Search\Odnoklassniki\Adapter;

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