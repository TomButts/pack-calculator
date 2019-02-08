<?php

namespace app\components;

class Helper
{
    /**
     * Simply add up elements in an array
     *
     * @param array $array
     * @return integer
     */
    public static function sumArray(array $array)
    {
        return array_reduce($array, function($carry, $value) {
            return $carry += $value;
        });
    }
}