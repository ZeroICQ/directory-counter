<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

class App extends SingleCommandApplication
{
    public function __construct()
    {
        parent::__construct('Directory counter');
    }

    protected function configure(): void
    {
        $this->setVersion('0.1')->addArgument('path', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        $output->writeln($path);

        return Command::SUCCESS;
    }
}
