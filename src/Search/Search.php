<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Search;


use execut\peopleFinder\Person\Person;

interface Search
{
    public function next():bool;
    public function current():?Person;
    public function getTotalCount():int;
}