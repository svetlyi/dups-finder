<?php

namespace DupsFinder\Service;

use DupsFinder\File;

/**
 * Class Duplicates
 * A service to find same files.
 *
 * @package DupsFinder\Service
 */
class Duplicates
{
    /**
     * Generator, that yields files paths.
     *
     * @param array $files
     * @return array
     */
    public function find(array $files): array
    {
        $filesWithTheSameHashes = [];

        /** @var File $file */
        foreach ($files as $fileIndex => $file) {
            $hash = $file->getHash();
            if (isset($filesWithTheSameHashes[$hash])) {
                $filesWithTheSameHashes[$hash][] = $file->getPath();
            } else {
                $filesWithTheSameHashes[$hash] = [$file->getPath()];
            }
        }

        return array_filter(
            $filesWithTheSameHashes,
            function ($files, $hash) {
                return count($files) > 1;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}