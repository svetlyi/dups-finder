<?php

namespace DupsFinder;

/**
 * Class File
 * Holds information about
 * one file.
 *
 * @package DupsFinder
 */
class File
{
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return File
     */
    public function setHash(string $hash): File
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->filePath;
    }
}