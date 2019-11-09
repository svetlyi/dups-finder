<?php

namespace DupsFinder\Thread;

use Worker;

class FileHashWorker extends Worker
{
    /**
     * @var FileDataProvider
     */
    private $provider;

    /**
     * @param FileDataProvider $provider
     */
    public function __construct(FileDataProvider $provider)
    {
        $this->provider = $provider;
    }

    public function run()
    {
    }

    /**
     * @return FileDataProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}