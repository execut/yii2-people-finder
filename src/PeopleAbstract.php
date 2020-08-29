<?php
/**
 */

namespace execut\peoplesFinder;


use execut\peoplesFinder\people\Info;

abstract class PeopleAbstract implements PeopleInterface
{
    public function getFirstName() {
        return explode(' ', $this->getName())[0];
    }

    public function getHusbandName() {
        $nameParts = explode('(', $this->getName());
        if (!empty($nameParts[1])) {
            $part = explode(' ', $nameParts[0])[1];

            return $part;
        }

        $parts = explode(' ', $this->getName());

        return $parts[count($parts) - 1];
    }

    public function getSurname()
    {
        $nameParts = explode('(', $this->getName());
        if (!empty($nameParts[1])) {
            return trim($nameParts[1], ')');
        }

        $parts = explode(' ', $this->getName());

        return $parts[count($parts) - 1];
    }

    public function isEqual(PeopleInterface $people):bool {
        if (mb_strtolower($this->getFirstName()) !== mb_strtolower($people->getFirstName())) {
            return false;
        }

        $peopleNames = [
            mb_strtolower($people->getHusbandName()),
            mb_strtolower($people->getSurname())
        ];
        $peopleNames = array_filter($peopleNames);

        $selfNames = [
            mb_strtolower($this->getHusbandName()),
            mb_strtolower($this->getSurname())
        ];
        $selfNames = array_filter($selfNames);
        foreach ($peopleNames as $peopleName) {
            if (in_array($peopleName, $selfNames)) {
                return true;
            }
        }

        return false;
    }
}