<?php

namespace FileSystem;

abstract class Scanner implements \IteratorAggregate
{
    private $filters;

    private $commands;

    private $path;

    private $directoryIterator;

    /**
     * @param \FileSystem\FileSystem\Entity $file
     */
    public function __construct(\FileSystem\FileSystem\Entity $file)
    {
        $this->filters  = new \SplObjectStorage();
        $this->commands = new \SplObjectStorage();
        $this->path     = $file;

        $this->directoryIterator = new \RecursiveDirectoryIterator($file->getPathname());
        $this->directoryIterator->setFlags(
            \RecursiveDirectoryIterator::CURRENT_AS_FILEINFO | \RecursiveDirectoryIterator::SKIP_DOTS
        );
        $this->directoryIterator->setInfoClass($this->getInfoClassName());
        $this->addDefaultFilters();
    }

    abstract protected function getInfoClassName();

    abstract protected function addDefaultFilters();

    public function addFilter(\FileSystem\Filter\FilterInterface $filter)
    {
        $this->filters->attach($filter);

        return $this;
    }

    public function addCommand(\FileSystem\Command\AbstractCommand $command)
    {
        $this->commands->attach($command);

        return $this;
    }

    public function getCollection()
    {
        $collection = new \FileSystem\Collection();

        foreach ($this->filters as $filter) {
            $iterator = new \RecursiveIteratorIterator(
                $this->directoryIterator,
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($iterator as $directory) {
                if ($filter->accept($directory)) {
                    $collection->append($directory);
                }
            }
        }

        return $collection;
    }

    public function getIterator()
    {
        return $this->getCollection();
    }

    public function executeCommands()
    {
        $chain = new \FileSystem\Command\Chain($this->getCollection());

        foreach ($this->commands as $command) {
            $chain->addCommand($command);
        }

        $chain->execute();

        return $this;
    }
}