<?php

namespace App\Counter;

interface CounterInterface
{
    /**
     * Add $number to counter.
     *
     * @param int|string $number should be castable to number
     *
     * @throws \ValueError if not able cast $number to number
     */
    public function add(string|int $number): void;

    /**
     * Returns value of counter.
     */
    public function getValue(): string;
}
