<?php

namespace App\Counter;

abstract class AbstractCounter implements CounterInterface
{
    /**
     * Validate string is integer number.
     *
     * @throws \ValueError
     */
    protected function validateNumber(string|int $number): void
    {
        if (!is_string($number)) {
            return;
        }
        if (!preg_match('/^-?\\d+$/', $number)) {
            $numberTruncated = substr($number, 0, 20).'...';

            throw new \ValueError("\"{$numberTruncated}\" is not an integer.");
        }
    }
}
