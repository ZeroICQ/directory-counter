<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class HWTest extends TestCase
{
    public function testName(): void
    {
        $a = 'name';
        $this->assertSame('name', $a);
        $this->markTestIncomplete();
    }
}
