<?php

namespace DupsFinder;

use Worker;

class FileHashWorker extends Worker
{
    /**
     * @var FileHashesDataProvider
     */
    private $provider;

    /**
     * @param FileHashesDataProvider $provider
     */
    public function __construct(FileHashesDataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Вызывается при отправке в Pool.
     */
    public function run()
    {
    }

    /**
     * Возвращает провайдера
     *
     * @return FileHashesDataProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}