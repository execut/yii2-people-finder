<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Tests\Unit\Name\Comparator;


use Codeception\Test\Unit;
use execut\peopleFinder\Name\Comparator\Comparator;
use execut\peopleFinder\Name\Simple;

class ComparatorTest extends Unit
{
    public function testCompare()
    {
        $nameA = new Simple('Тёст');
        $nameB = new Simple('тест');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareViaNormalizer()
    {
        $nameA = new Simple('Настя');
        $nameB = new Simple('Анастасия');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareWithoutChar()
    {
        $nameA = new Simple('ИмяДлинное');
        $nameB = new Simple('ИмяДлинно');
        $comparator = new Comparator();
        $this->assertEquals(90.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareWithoutCharAtMiddle()
    {
        $nameA = new Simple('ИмяДлинное');
        $nameB = new Simple('Имялинное');
        $comparator = new Comparator();
        $this->assertEquals(90.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareWithoutCharAtStart()
    {
        $nameA = new Simple('ИмяДлинное');
        $nameB = new Simple('мяДлинное');
        $comparator = new Comparator();
        $this->assertEquals(90.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualName()
    {
        $nameA = new Simple('Имя Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameInverse()
    {
        $nameA = new Simple('Имя');
        $nameB = new Simple('Имя Фамилия (ФамилияПриРождении)');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndSurname()
    {
        $nameA = new Simple('Имя Отчество Фемилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя Фёмилия');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndSurnamesInvert()
    {
        $nameA = new Simple('Имя Отчество Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя Другая-Фамилия');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndNotEqualSurname()
    {
        $nameA = new Simple('Имя Отчество Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя Фамили');
        $comparator = new Comparator();
        $this->assertEquals(0.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndSurnameInverse()
    {
        $nameA = new Simple('Имя Фамилия');
        $nameB = new Simple('Имя Отчество Фамилия (ФамилияПриРождении)');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndSurnameAndSurnameAtBirth()
    {
        $nameA = new Simple('Имя Отчество Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя Фамилия (ФамилияПриРождении)');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualNameAndSurnameAndSurnameAtBirthInverse()
    {
        $nameA = new Simple('123 456 (789)');
        $nameB = new Simple('123 222 456 (789)');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualSurnameAndSurnameAtBirth()
    {
        $nameA = new Simple('Имя Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя ФамилияПриРождении (Фамилия)');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }

    public function testCompareEqualSurnameAndSurnameAtBirthWhenOneSurnameAtBirthIsEmpty()
    {
        $nameA = new Simple('Имя Фамилия (ФамилияПриРождении)');
        $nameB = new Simple('Имя ФамилияПриРождении');
        $comparator = new Comparator();
        $this->assertEquals(100.0, $comparator->compare($nameA, $nameB));
    }
}