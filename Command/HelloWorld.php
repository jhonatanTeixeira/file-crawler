<?php

namespace Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('hello:world')
            ->setDescription('Hello world Command');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello World');
    }
}
