<?php

namespace Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class StartProcess extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('process:start')
            ->setDescription('Start a process')
            ->addArgument('name', InputArgument::REQUIRED, 'Process name to start, it will run on backgorund')
            ->addOption(
                'params', 
                'p', 
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 
                'params to be used on the process',
                array()
            );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        declare(ticks = 1);
        
        $forker = new \Process\Forker();
        $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        
        $processes            = require 'configs/process_map.php';
        $processesSubscribers = require 'configs/process_subscribers.php';
        
        $processName = $input->getArgument('name');
        
        if (!isset($processes[$processName])) {
            throw new \RuntimeException("process with name '$processName' not found on process map");
        }
        
        if (isset($processesSubscribers[$processName])) {
            foreach ($processesSubscribers[$processName] as $subscriberName) {
                $subscriber = new $subscriberName();
                $eventDispatcher->addSubscriber($subscriber);
            }
        }
        
        $proccess = new $processes[$processName]($input, $eventDispatcher);
        
        $forker->fork($proccess);
    }
}
