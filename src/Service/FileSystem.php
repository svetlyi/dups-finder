<?php

namespace DupsFinder\Service;

use Generator;

/**
 * Class FileSystem
 * A service to work with a file system.
 *
 * @package DupsFinder\Service
 */
class FileSystem
{
    /**
     * Generator, that yields files paths.
     *
     * @param string $folderWhereToSearch
     * @return Generator
     */
    public function getFiles(string $folderWhereToSearch): Generator
    {
        if (is_readable($folderWhereToSearch) && $handle = opendir($folderWhereToSearch)) {
            while (false !== ($filePath = readdir($handle))) {
                if ('.' === $filePath) continue;
                if ('..' === $filePath) continue;
                $filePath = $folderWhereToSearch . DIRECTORY_SEPARATOR . $filePath;
                if (is_dir($filePath)) {
                    /** @var string $subFilePath - file path from a child directory */
                    foreach ($this->getFiles($filePath) as $subFilePath) {
                        yield $subFilePath;
                    }
                } else {
                    yield $filePath;
                }
            }
            closedir($handle);
        }
    }
}