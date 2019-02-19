<?php

namespace DupsFinder;

use Threaded;

class CalculateHashWork extends Threaded
{
    public function run()
    {
        do {
            /** @var int|null $fileIndex */
            $fileIndex = null;

            /** @var FileHashesDataProvider $provider */
            $provider = $this->worker->getProvider();

            // Синхронизируем получение данных
            $provider->synchronized(function(FileHashesDataProvider $provider) use (&$fileIndex) {
                $fileIndex = $provider->getNext();
            }, $provider);

            if ($fileIndex === null) {
                continue;
            }

            $file = ((array)$provider->getFiles())[$fileIndex];
            $hash = md5_file($file->getPath());
            $provider->setHash($hash, $fileIndex);
        }
        while ($fileIndex !== null);
    }
}