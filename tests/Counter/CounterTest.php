<?php

namespace App\Tests;

use App\Counter\Counter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CounterTest extends TestCase
{
    public function testDefaultInit(): void
    {
        $c = new Counter();
        $this->assertSame('0', $c->getValue());
    }

    public function testIntInit(): void
    {
        $c = new Counter(1234);
        $this->assertSame('1234', $c->getValue());
    }

    public function testFloatStrInit(): void
    {
        $this->expectException(\ValueError::class);
        $c = new Counter('112.5111111111');
    }

    public function testInitValueException(): void
    {
        $this->expectException(\ValueError::class);
        $c = new Counter('totally not a number');
    }

    /**
     * @return array<int[]>
     */
    public static function simpleSumProvider(): array
    {
        return [
            [2, 1, 1],
            [-10, -8, -2],
            [101, 0, -1000, 900, 200, 1],
        ];
    }

    #[DataProvider('simpleSumProvider')]
    public function testSimpleSum(int $expectedSum, int ...$args): void
    {
        $c = new Counter();
        foreach ($args as $arg) {
            $c->add($arg);
        }

        $expectedSumStr = (string) $expectedSum;
        $this->assertSame($expectedSumStr, $c->getValue());
    }

    public function testFloatSum(): void
    {
        $c = new Counter();
        $this->expectException(\ValueError::class);
        $c->add('-12.13');
    }

    public function testIntegerOverflow(): void
    {
        $c = new Counter('9223372036854775807');
        $c->add('10');
        $this->assertSame('9223372036854775817', $c->getValue());
    }
}
