<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Name;


class Simple implements Name
{
    protected string $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
//    public function getFirstName() {
//        return explode(' ', $this->getName())[0];
//    }
//
//    public function getHusbandName() {
//        $nameParts = explode('(', $this->getName());
//        if (!empty($nameParts[1])) {
//            $part = explode(' ', $nameParts[0])[1];
//
//            return $part;
//        }
//
//        $parts = explode(' ', $this->getName());
//
//        return $parts[count($parts) - 1];
//    }
//
//    public function getSurname()
//    {
//        $nameParts = explode('(', $this->getName());
//        if (!empty($nameParts[1])) {
//            return trim($nameParts[1], ')');
//        }
//
//        $parts = explode(' ', $this->getName());
//
//        return $parts[count($parts) - 1];
//    }
//
//    public function isEqual(PeopleInterface $people):bool {
//        if (mb_strtolower($this->getFirstName()) !== mb_strtolower($people->getFirstName())) {
//            return false;
//        }
//
//        $peopleNames = [
//            mb_strtolower($people->getHusbandName()),
//            mb_strtolower($people->getSurname())
//        ];
//        $peopleNames = array_filter($peopleNames);
//
//        $selfNames = [
//            mb_strtolower($this->getHusbandName()),
//            mb_strtolower($this->getSurname())
//        ];
//        $selfNames = array_filter($selfNames);
//        foreach ($peopleNames as $peopleName) {
//            if (in_array($peopleName, $selfNames)) {
//                return true;
//            }
//        }
//
//        return false;
//    }
}