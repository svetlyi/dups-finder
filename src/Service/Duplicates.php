<?php

namespace DupsFinder\Service;

use DupsFinder\File;

/**
 * Class Duplicates
 * A service to find the same files.
 *
 * @package DupsFinder\Service
 */
class Duplicates
{
    /**
     * Finds files with the same hash
     * and returns duplicates.
     * ```php
     *  [
     *      'hash' => ['file/path/one', 'file/path/two' ...],
     *      ...
     *  ]
     * ```
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