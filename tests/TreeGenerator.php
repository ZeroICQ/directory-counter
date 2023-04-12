<?php

namespace App\Tests;

class TreeGenerator
{
    private \GMP $count;

    public function __construct(
        private readonly string $rootPath,
        int $seed,
        private readonly int $maxDepth = 3,
    ) {
        srand($seed);
        $this->count = gmp_init(0);
    }

    public function getSum(): string
    {
        return gmp_strval($this->count);
    }

    public function generate(): void
    {
        $depth = 0;
        foreach (range(0, 20) as $i) {
            if ($this->tossCoin(80)) {
                $dirPath = $this->createDir($this->rootPath, (string) $i);
                $this->generateRecursive($dirPath, $depth + 1);
            }
        }

        $this->createGoodFile($this->rootPath);
    }

    private function generateRecursive(string $dirPath, int $depth): void
    {
        if ($depth >= $this->maxDepth) {
            return;
        }

        foreach (range(0, 10) as $i) {
            if ($this->tossCoin(50)) {
                $childDirPath = $this->createDir($dirPath, (string) $i);
                $this->generateRecursive($childDirPath, $depth + 1);
            }

            if ($this->tossCoin(30)) {
                $this->createRndFile($dirPath);
            }
        }

        if ($this->tossCoin(50)) {
            $this->createGoodFile($dirPath);
        } else {
            $this->createBadFile($dirPath);
        }
    }

    /**
     * Toss a coin, get true or false.
     *
     * @param int $successPercent integer in [1,100] out of 100 - chance of returning true
     */
    private function tossCoin(int $successPercent): bool
    {
        $coinValue = rand(1, 100);

        return $coinValue <= $successPercent;
    }

    private function createDir(string $rootPath, string $dirName): string
    {
        $dirPath = $rootPath."/{$dirName}";
        mkdir($dirPath);

        return $dirPath;
    }

    private function createGoodFile(string $dirPath): void
    {
        $value = rand();
        file_put_contents($dirPath.'/count', $value);
        $this->count = gmp_add($this->count, $value);
    }

    private function createRndFile(string $dirPath): void
    {
        $value = rand(100, PHP_INT_MAX);
        file_put_contents("{$dirPath}/{$value}.txt", $value);
    }

    private function createBadFile(string $dirPath): void
    {
        $value = 'Totally not a number';
        file_put_contents($dirPath.'/count', $value);
    }
}
