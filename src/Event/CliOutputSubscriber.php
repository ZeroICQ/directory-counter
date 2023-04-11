<?php

namespace App\Event;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CliOutputSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected readonly OutputInterface $output
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FileOpenExceptionEvent::NAME => 'onFileOpenException',
        ];
    }

    public function onFileOpenException(FileOpenExceptionEvent $event): void
    {
        $this->output->writeln("\n<info>Could not read file \"{$event->getFilePath()}\". Error: {$event->getException()->getMessage()}</info>");
    }
}
