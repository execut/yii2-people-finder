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

    public function getFirstname(): string
    {
        $parts = $this->getNameParts();

        $name = $parts[0];

        return $name;
    }

    protected function getNameParts(): array
    {
        return explode(' ', $this->name);
    }

    public function getSurname(): ?string
    {
        $fullSurname = $this->getFullSurname();
        if (strpos($fullSurname, '-') !== false) {
            $parts = explode('-', $fullSurname);
            return $parts[0];
        }

        return $fullSurname;
    }

    public function getSecondSurname(): ?string
    {
        $fullSurname = $this->getFullSurname();
        if (strpos($fullSurname, '-') !== false) {
            $parts = explode('-', $fullSurname);
            if (!empty($parts[1])) {
                return $parts[1];
            }
        }

        return null;
    }

    public function getSurnameAtBirth(): ?string
    {
        $parts = $this->getNameParts();
        if (empty($parts[1])) {
            return null;
        }

        if (count($parts) == 2 && $this->isSurnameAtBirth($parts[1])) {
            return trim($parts[1], '()');
        } else if (count($parts) == 3 && $this->isSurnameAtBirth($parts[2])) {
            return trim($parts[2], '()');
        } else if (count($parts) == 4 && $this->isSurnameAtBirth($parts[3])) {
            return trim($parts[3], '()');
        }

        return null;
    }

    protected function isSurnameAtBirth($name)
    {
        return strpos($name, '(') !== false;
    }

    public function getSecondname(): ?string
    {

        $parts = $this->getNameParts();
        if (empty($parts[1])) {
            return null;
        }

        if (count($parts) == 3 && !$this->isSurnameAtBirth($parts[2]) || count($parts) == 4) {
            return $parts[1];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    protected function getFullSurname()
    {
        $parts = $this->getNameParts();
        if (empty($parts[1])) {
            return null;
        }

        if (count($parts) == 2) {
            return $parts[1];
        }

        if (count($parts) > 2) {
            if (!$this->isSurnameAtBirth($parts[2])) {
                return $parts[2];
            } else {
                return $parts[1];
            }
        }

        return null;
    }
}