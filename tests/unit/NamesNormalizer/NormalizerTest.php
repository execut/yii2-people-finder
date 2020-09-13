<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Tests\Unit\NamesNormalizer;


use execut\peopleFinder\NamesNormalizer\Normalizer;
use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{
    public function testNormalize()
    {
        $normalizer = new Normalizer();
        $this->assertEquals('Юрий', $normalizer->normalize('Юрик'));
    }

    public function testNormalizeNormalizedName()
    {
        $normalizer = new Normalizer();
        $this->assertEquals('Юрий', $normalizer->normalize('Юрий'));
    }

    public function testNormalizeUnexistedName()
    {
        $normalizer = new Normalizer();
        $this->assertNull($normalizer->normalize('Юрий 2'));
    }
}