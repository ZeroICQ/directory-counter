<?php

namespace App\Tests;

use App\App;
use PHPUnit\Framework\TestCase;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use Symfony\Component\Console\Tester\CommandTester;

class AppTest extends TestCase
{
    private TemporaryDirectory $tmpDir;
    private string $realSum;

    protected function setUp(): void
    {
        parent::setUp();
        if ('testGeneratedTree' === $this->name()) {
            $this->tmpDir = (new TemporaryDirectory())->create();
            $treeGenerator = new TreeGenerator($this->tmpDir->path(), 102);
            $treeGenerator->generate();
            $this->realSum = $treeGenerator->getSum();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ('testGeneratedTree' === $this->name()) {
            $this->tmpDir->delete();
        }
    }

    public function testFixtures(): void
    {
        $appTester = $this->runApplication(__DIR__.'/../fixtures');

        $this->assertSame(0, $appTester->getStatusCode());
        $outValue = $this->getOutputValue($appTester);
        $this->assertSame('122', $outValue);
    }

    public function testGeneratedTree(): void
    {
        $tester = $this->runApplication($this->tmpDir->path());
        $outValue = $this->getOutputValue($tester);
        $this->assertSame($this->realSum, $outValue);
    }

    /**
     * Helper to run application.
     */
    private function runApplication(string $dirPath): CommandTester
    {
        $application = (new App())
            ->setAutoExit(false)
        ;

        $appTester = new CommandTester($application);
        $appTester->execute(
            [
                'path' => $dirPath,
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
