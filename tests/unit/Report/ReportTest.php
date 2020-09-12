<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\tests\unit\Report;


use Codeception\Test\Unit;
use execut\peopleFinder\PeopleComparator\Result;

class ReportTest extends Unit
{
    public function testRun() {
        $people = new People();
        $result = new Result($people, 50);

        $result = new Report([$result, $result]);
        $this->assertEquals(<<<TEXT
123;Test User;50
TEXT
, $result);
    }
}