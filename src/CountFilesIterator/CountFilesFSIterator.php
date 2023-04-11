<?php

namespace App\CountFilesIterator;

use App\Event\FileOpenExceptionEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CountFilesFSIterator implements CountFilesIteratorInterface
{
    public const MAX_FILE_SIZE = 1048576; // 1 MB in bytes
    private string $countFileRegEx = '/^count$/';

    public function __construct(
        private readonly string $rootPath,
        protected readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function getIterator(): \Traversable
    {
        return $this->gen();
    }

    /**
     * @return \Generator<string, string> filePath, value
     */
    private function gen(): \Generator
    {
        $iter = $this->buildIterator();

        /** @var \SplFileInfo $fileInfo */
        foreach ($iter as $fileInfo) {
            if ($this->filterByName($fileInfo->getFilename())) {
                continue;
            }

            try {
                $value = $this->getValueFromFile($fileInfo);

                yield $fileInfo->getPathname() => $value;
            } catch (\Throwable $ex) {
                $event = new FileOpenExceptionEvent($fileInfo->getPathname(), $ex);
                $this->eventDispatcher->dispatch($event, FileOpenExceptionEvent::NAME);
            }
        }
    }

    /**
     * Tries to get value from file in the safest way possible.
     */
    private function getValueFromFile(\SplFileInfo $fileInfo): string
    {
        $fileSize = $fileInfo->getSize();
        if ($fileSize > self::MAX_FILE_SIZE) {
            throw new \ValueError('File is too large');
        }

        $file = fopen($fileInfo->getRealPath(), 'r');
        if (!$file) {
            throw new \ValueError('Can\'t open file');
        }

        try {
            $content = fread($file, self::MAX_FILE_SIZE);
            if (false === $content) {
                throw new \ValueError('Can\'t read file\'s contents');
            }

            return $content;
        } finally {
            fclose($file);
        }
    }

    /**
     * @return bool true if filename doesn't satisfy requirements, false otherwise
     */
    private function filterByName(string $filename): bool
    {
        if (!preg_match($this->countFileRegEx, $filename)) {
            return true;
        }

        return false;
    }

    /**
     * @return \Traversable<\SplFileInfo>
     */
    private function buildIterator(): \Traversable
    {
        // iterator over files
        $recursiveDirectoryIterator = new \RecursiveDirectoryIterator(
            $this->rootPath,
            \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS
        );
        // make flat from recursive
        return new \RecursiveIteratorIterator(
            $recursiveDirectoryIterator,
            flags: \RecursiveIteratorIterator::CATCH_GET_CHILD // skipping unreadable directories silently. todo: print message
        );
    }
}
