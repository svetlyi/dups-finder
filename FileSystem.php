<?php

namespace DupsFinder;

class FileSystem
{
    /**
     * @param $folderWhereToSearch
     * @return File[]
     */
    public function getFileList(string $folderWhereToSearch): array
    {
        $files = [];
        if (is_readable($folderWhereToSearch) && $handle = opendir($folderWhereToSearch)) {
            while (false !== ($filePath = readdir($handle))) {
                if ('.' === $filePath) continue;
                if ('..' === $filePath) continue;
                $filePath = $folderWhereToSearch . DIRECTORY_SEPARATOR . $filePath;
                if (is_dir($filePath)) {
                    $files = array_merge($files, $this->getFileList($filePath));
                } else {
                    $files[] = new File($filePath, filesize($filePath));
                }
                status_bar(count($files), 'files found in ' . $folderWhereToSearch);
            }
            closedir($handle);
        }
        return $files;
    }
}