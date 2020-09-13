<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Friends;


use execut\peopleFinder\Person\Person;

class Simple implements Friends
{
    protected array $data;
    protected int $position = 0;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function current(): ?Person
    {
        if (empty($this->data[$this->position])) {
            return null;
        }

        return $this->data[$this->position];
    }

    public function reset()
    {
        $this->position = 0;
    }

    public function next(): bool
    {
        if (empty($this->data[$this->position + 1])) {
            $result = false;
        } else {
            $result = true;
        }

        $this->position++;

        return $result;
    }

    public function getTotalCount():int
    {
        return count($this->data);
    }
}