<?php

namespace App;

use App\Counter\Counter;
use App\CountFilesIterator\CountFilesFSIterator;
use App\Event\CliOutputSubscriber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\EventDispatcher\EventDispatcher;

class App extends SingleCommandApplication
{
    public function __construct()
    {
        parent::__construct('Counter');
    }

    protected function configure(): void
    {
        $this->setVersion('0.1')->addArgument('path', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = (string) $input->getArgument('path');
        $eventDispatcher = $this->setupEventDispatcher($output);

        $counter = new Counter();
        $counterFilesIterator = new CountFilesFSIterator($path, $eventDispatcher);

        $progressBar = new ProgressBar($output);

        foreach ($counterFilesIterator as $filePath => $value) {
            try {
                $counter->add($value);
            } catch (\ValueError $e) {
                $output->writeln("<info>Error while reading file {$filePath}. Error: {$e->getMessage()}</info>");
            }
        }

        $output->writeln("Count: {$counter->getValue()}");

        return Command::SUCCESS;
    }

    private function setupEventDispatcher(OutputInterface $output): EventDispatcher
    {
        $evenDispatcher = new EventDispatcher();
        $evenDispatcher->addSubscriber(new CliOutputSubscriber($output));

        return $evenDispatcher;
    }
}
