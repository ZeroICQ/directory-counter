<?php

namespace App\Counter;

use ValueError;

abstract class AbstractCounter implements CounterInterface
{
    /**
     * Validate string is integer number.
     *
     * @param string|int $number
     * @return void
     *
     */
    protected function validateNumber(string|int $number): void
    {
        if (!is_string($number)) {
            return;
        }
        if (!preg_match("/^-?\d+$/", $number)) {
            throw new ValueError("\"{$number}\" is not an integer.");
        }
    }
}
