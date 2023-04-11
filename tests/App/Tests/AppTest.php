<?php

namespace App\Tests;

use App\App;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AppTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFixtures(): void
    {
        $appTester = $this->runApplication(__DIR__.'/../../../fixtures');

        $this->assertSame(0, $appTester->getStatusCode());
        $count = $this->getOutputValue($appTester);
        $this->assertSame('122', $count);
    }

    /**
     * Helper to run application.
     */
    private function runApplication(string $filePath): CommandTester
    {
        $application = (new App())
            ->setAutoExit(false)
        ;

        $appTester = new CommandTester($application);
        $appTester->execute(
            [
                'path' => $filePath,
            ],
            [
                'decorated' => false,
                'interactive' => false,
                'capture_stderr_separately' => true,
            ]
        );

        return $appTester;
    }

    /**
     * Parse output to get count value.
     */
    private function getOutputValue(CommandTester $appTester): string
    {
        $lines = explode(PHP_EOL, $appTester->getDisplay());

        return explode(' ', $lines[count($lines) - 2])[1];
    }
}
