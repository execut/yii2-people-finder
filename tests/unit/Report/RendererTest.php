<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\peopleFinder\tests\unit\Report;

use Codeception\Test\Unit;
use execut\peopleFinder\PeopleComparator\Comparator\Comparator;
use execut\peopleFinder\PeopleComparator\Result;
use execut\peopleFinder\Person\Simple;
use execut\peopleFinder\Report\Renderer;

class RendererTest extends Unit
{
    public function testRun()
    {
        $personFinded = new Simple('123', new \execut\peopleFinder\Name\Simple('Test User'));
        $personForCompare20 = new Simple('456', new \execut\peopleFinder\Name\Simple('Test User 20'));
        $personForCompare50 = new Simple('789', new \execut\peopleFinder\Name\Simple('Test User 50'));
        $result50 = new Result($personForCompare50, 50);
        $result20 = new Result($personForCompare20, 20);
        $comparator = $this->getMockBuilder(Comparator::class)->setMockClassName('ComparatorName') ->getMock();
        $comparator->method('compare')
            ->willReturnMap([
                [$personFinded, $personForCompare20, $result20],
                [$personFinded, $personForCompare50, $result50],
            ]);

        $renderer = new Renderer($personFinded, [$personForCompare20, $personForCompare50], [$comparator]);
        ob_start();
        $renderer->render();
        $this->assertEquals(<<<TEXT
Id;Name;ComparatorName;
456;Test User 20;20;
789;Test User 50;50;

TEXT
, ob_get_clean());
    }
}