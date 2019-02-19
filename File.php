<?php

namespace DupsFinder;

class File
{
    private $path;
    private $size;
    private $hash;

    public function __construct(string $path, int $size)
    {
        $this->path = $path;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return File
     */
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize():int
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return File
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;
        return $this;
    }
}