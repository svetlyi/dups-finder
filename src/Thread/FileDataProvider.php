<?php

namespace DupsFinder\Thread;

use DupsFinder\File;
use DupsFinder\Service\FileSystem;
use Threaded;

/**
 * Class FileHashesDataProvider
 * The class is the storage of calculated hashes
 * of the files.
 *
 * @package DupsFinder
 */
class FileDataProvider extends Threaded
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var FileSystem
     */
    private $fileSystem;

    /**
     * @var File[]
     */
    private $files = [];

    /**
     * Counter to see what is the current file being processed.
     *
     * @var int
     */
    private $fileCounter = -1;

    /**
     * FileDataProvider constructor.
     *
     * @param string $filePath - initial path where to get the files from.
     * @param FileSystem $fileSystem
     */
    public function __construct(string $filePath, FileSystem $fileSystem)
    {
        $this->filePath = $filePath;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Initialize the array with files.
     *
     * @return void
     */
    public function initFilesList(): void
    {
        foreach ($this->fileSystem->getFiles($this->filePath) as $filePath) {
            $file = new File($filePath);
            $this->files[] = $file;
        }
    }

    public function incrementCounter()
    {
        $this->fileCounter++;
    }

    /**
     * @param string $hash
     * @param int $fileIndex
     */
    public function setHash(string $hash, int $fileIndex): void
    {
        $file = $this->files[$fileIndex];
        $file->setHash($hash);
        $this->files[$fileIndex] = $file;
    }

    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return int
     */
    public function getFileCounter(): int
    {
        return $this->fileCounter;
    }
}