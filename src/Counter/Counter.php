<?php

namespace App\Counter;

use GMP;
use ValueError;

class Counter extends AbstractCounter
{
    private GMP $value;

    /**
     * @param string|int $start
     *
     * @throws ValueError
     */
    public function __construct(string|int $start = 0)
    {
        $this->validateNumber($start);
        $this->value = gmp_init($start, 10);
    }

    /**
     * {@inheritDoc}
     */
    public function add(string|int $number): void
    {
        $this->validateNumber($number);
        $this->value = gmp_add($this->value, $number);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return gmp_strval($this->value);
    }

}
