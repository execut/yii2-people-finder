<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Name;


interface Name
{
    public function getName(): string;
    public function getSurname(): ?string;
    public function getSecondSurname(): ?string;
    public function getFirstname(): string;
    public function getSecondname(): ?string;
    public function getSurnameAtBirth(): ?string;
}