<?php

use DupsFinder\FileSystem;

require_once 'utils.php';
require_once 'FileSystem.php';
require_once 'FileHashesDataProvider.php';
require_once 'FileHashWorker.php';
require_once 'CalculateHashWork.php';
require_once 'File.php';

$fileSystem = new FileSystem();

if ($argc !== 3) {
    printit('Provide a directory to search in and a file to write logs!!!!!111');
    die();
}

$folderWhereToSearch = $argv[1];
$fileLogs = $argv[2];

printit("Collecting a list of files");

$files = $fileSystem->getFileList($folderWhereToSearch);

printit("Found " . count($files) . " files");
printit("Calculating hashes");

$hashes = [];

$threads = 4;
$provider = new \DupsFinder\FileHashesDataProvider();
$provider->setFiles($files);

$pool = new Pool($threads, \DupsFinder\FileHashWorker::class, [$provider]);

$workers = $threads;
for ($i = 0; $i < $workers; $i++) {
    $pool->submit(new \DupsFinder\CalculateHashWork());
}

$pool->shutdown();

$files = (array)$provider->getFiles();

printit("Grouping files by hashes");

foreach ($files as $fileIndex => $file) {
    $hash = $file->getHash();
    if (isset($hashes[$hash])) {
        $hashes[$hash][] = $file->getPath();
    } else {
        $hashes[$hash] = [$file->getPath()];
    }
    progress_bar($fileIndex, count($files), $fileIndex);
}

printit("Printing duplicates");
$dupsList = '';

foreach ($hashes as $hash => $hashMap) {
    if (count($hashMap) > 1) {
        $dupsList .= printit($hash);
        foreach ($hashMap as $file) {
            $dupsList .= printit("--- " . $file);
        }
    }
}

file_put_contents($fileLogs, $dupsList);
