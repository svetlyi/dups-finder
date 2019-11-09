<?php

namespace DupsFinder\Thread;

use Threaded;

class CalculateHashWork extends Threaded
{
    public function run()
    {
        /** @var FileDataProvider $provider */
        $provider = $this->worker->getProvider();
        $areThereMoreFiles = true;

        do {
            /** @var int|null $filePath */
            $fileIndex = null;

            $provider->synchronized(function(FileDataProvider $provider) use (&$fileIndex, &$areThereMoreFiles) {
                $provider->incrementCounter();
                $fileIndex = $provider->getFileCounter();

                if (count($provider->getFiles()) <= $provider->getFileCounter()) {
                    $areThereMoreFiles = false;
                }
            }, $provider);

            /**
             * no more files
             */
            if (!$areThereMoreFiles) {
                return;
            }

            if ($fileIndex === null) {
                continue;
            }

            $filePath = ((array)$provider->getFiles())[$fileIndex]->getPath();
            $hash = md5_file($filePath);
            $provider->setHash($hash, $fileIndex);
        }
        while (true);
    }
}