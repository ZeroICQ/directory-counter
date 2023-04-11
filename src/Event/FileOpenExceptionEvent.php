<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FileOpenExceptionEvent extends Event
{
    public const NAME = 'countfiles.iterator.exception.openfile';

    public function __construct(
        private readonly string $filePath,
        private readonly \Throwable $exception
    ) {
    }

    public function getException(): \Throwable
    {
        return $this->exception;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
