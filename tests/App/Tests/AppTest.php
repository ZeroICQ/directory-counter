<?php

namespace App\Tests;

use App\App;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AppTest extends TestCase
{
    public function testFixtures(): void
    {
        $application = new App();
        $application->setAutoExit(false);
        $appTester = new CommandTester($application);
        $code = $appTester->execute(
            [
                'path' => '/app/fixtures',
            ],
            [
                'decorated' => false,
                'interactive' => false,
                'capture_stderr_separately' => true,
            ]
        );
        //        $code = $appTester->execute(['command' => $application->getName(), '/app/fixtures'], );
        $this->assertSame(0, $code);
        $lines = explode(PHP_EOL, $appTester->getDisplay());
        $count = explode(' ', $lines[count($lines) - 2])[1];
        $this->assertSame('122', $count);
        //        $this->assertSame('a', $appTester->getDisplay());
    }
}
