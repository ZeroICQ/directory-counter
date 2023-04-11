<?php

namespace App\Counter;

abstract class AbstractCounter implements CounterInterface
{
    /**
     * Validate string is integer number.
     */
    protected function validateNumber(string|int $number): void
    {
        if (!is_string($number)) {
            return;
        }
        if (!preg_match('/^-?\\d+$/', $number)) {
            throw new \ValueError("\"{$number}\" is not an integer.");
        }
    }
}
