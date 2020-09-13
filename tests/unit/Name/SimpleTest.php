<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Tests\Unit\Name;


use Codeception\Test\Unit;
use execut\peopleFinder\Name\Simple;

class SimpleTest extends Unit
{
    const NAME = 'Имя';
    const NAME_AND_SURNAME = 'Имя Фамилия';
    const NAME_AND_SURNAME_AND_SECONDSURNAME = 'Имя Фамилия-ВтораяФамилия';
    const NAME_AND_SECONDNAME_SURNAME = 'Имя Отчество Фамилия';
    const NAME_AND_SECONDNAME_SURNAME_AND_SECONDSURNAME = 'Имя Отчество Фамилия-ВтораяФамилия';
    const NAME_AND_SURNAME_AND_BSURNAME = 'Имя Фамилия (ФамилияПриРождении)';
    const NAME_AND_SURNAME_AND_BSURNAME_AND_SECONDSURNAME = 'Имя Фамилия-ВтораяФамилия (ФамилияПриРождении)';
    const NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME = 'Имя Отчество Фамилия (ФамилияПриРождении)';
    const NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME_AND_SECONDSURNAME = 'Имя Отчество Фамилия-ВтораяФамилия (ФамилияПриРождении)';

    public function testFirstname()
    {
        $names = [
            self::NAME,
            self::NAME_AND_SURNAME,
            self::NAME_AND_SECONDNAME_SURNAME,
            self::NAME_AND_SURNAME_AND_BSURNAME,
            self::NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertEquals(self::NAME, $name->getFirstname(), 'When try name ' . $nameValue);
        }
    }

    public function testGetSurnameWithoutIt()
    {
        $name = new Simple(self::NAME);
        $this->assertNull($name->getSurname());
    }

    public function testGetSurname()
    {
        $names = [
            self::NAME_AND_SURNAME,
            self::NAME_AND_SURNAME_AND_SECONDSURNAME,
            self::NAME_AND_SECONDNAME_SURNAME,
            self::NAME_AND_SURNAME_AND_BSURNAME,
            self::NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertEquals('Фамилия', $name->getSurname(), 'When try name ' . $nameValue);
        }
    }

    public function testGetSecondSurnameWhenItEmpty()
    {
        $name = new Simple(self::NAME_AND_SURNAME);
        $this->assertNull($name->getSecondname());
    }

    public function testGetSecondSurname()
    {
        $name = new Simple(self::NAME_AND_SURNAME_AND_SECONDSURNAME);
        $this->assertEquals('ВтораяФамилия', $name->getSecondSurname());
    }

    public function testGetSecondnameWithoutIt()
    {
        $names = [
            self::NAME,
            self::NAME_AND_SURNAME,
            self::NAME_AND_SURNAME_AND_BSURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertNull($name->getSecondname(), 'When try name ' . $nameValue);
        }
    }

    public function testGetSecondname()
    {
        $names = [
            self::NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME,
            self::NAME_AND_SECONDNAME_SURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertEquals('Отчество', $name->getSecondname(), 'When try name ' . $nameValue);
        }
    }

    public function testGetSurnameAtBirthWithoutIt()
    {
        $names = [
            self::NAME,
            self::NAME_AND_SURNAME,
            self::NAME_AND_SECONDNAME_SURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertNull($name->getSurnameAtBirth(), 'When try name ' . $nameValue);
        }
    }

    public function testGetSurnameAtBirth()
    {
        $names = [
            self::NAME_AND_SECONDNAME_AND_SURNAME_AND_BSURNAME,
            self::NAME_AND_SURNAME_AND_BSURNAME,
        ];
        foreach ($names as $nameValue) {
            $name = new Simple($nameValue);
            $this->assertEquals('ФамилияПриРождении', $name->getSurnameAtBirth(), 'When try name ' . $nameValue);
        }
    }
}