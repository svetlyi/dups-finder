<?php

namespace DupsFinder;

use Threaded;

class FileHashesDataProvider extends Threaded
{
    /**
     * @var File[]
     */
    private $files;

    private $counter = -1;

    /**
     * @param File[] $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    /**
     * Переходим к следующему элементу и возвращаем его
     *
     * @return int
     */
    public function getNext()
    {
        $files = (array)$this->files;
        $this->counter++;
        status_bar($this->counter, 'file counter. Files: ' . \count($files));

        if (isset($files[$this->counter])) {
            return $this->counter;
        }

        return null;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setHash(string $hash, int $fileIndex)
    {
        $file = $this->files[$fileIndex];
        $file->setHash($hash);
        $this->files[$fileIndex] = $file;
    }
}