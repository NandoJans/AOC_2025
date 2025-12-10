<?php

namespace core;

class Sorter
{
    public function sortByArraySize(array $array): array
    {
        usort($array, function ($a, $b) {
            return -(sizeof($a) <=> sizeof($b));
        });
        return $array;
    }
}