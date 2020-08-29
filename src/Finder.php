<?php
/**
 */

namespace execut\peoplesFinder;


class Finder
{
    public function find($query) {
        $result = new Result($query);
        return $result;
    }
}