<?php

namespace Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class StartProcess extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('process:start')
            ->setDescription('Start a process')
            ->addArgument('name', InputArgument::REQUIRED, 'Process name to start, it will run on backgorund');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        declare(ticks = 1);
        
        $forker = new \Proccess\Forker();
        
        
    }
}
