<?php

namespace App\Counter;

use ValueError;

interface CounterInterface
{
    /**
     * Add $number to counter
     *
     * @param string|int $number Should be castable to number.
     *
     * @return void
     *
     * @throws ValueError If not able cast $number to number.
     */
    public function add(string|int $number): void;

    /**
     * Returns value of counter.
     *
     * @return string
     */
    public function getValue(): string;

}
