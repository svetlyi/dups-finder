<?php

namespace DupsFinder\Command;

use DupsFinder\Service\Duplicates;
use DupsFinder\Service\FileSystem;
use DupsFinder\Thread\CalculateHashWork;
use DupsFinder\Thread\FileDataProvider;
use DupsFinder\Thread\FileHashWorker;
use Pool;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FindDuplicates extends Command
{
    protected static $defaultName = 'app:find-dups';

    protected function configure()
    {
        $this->setDescription('Finds duplicates in a folder.')
            ->setHelp('This command finds duplicates in a specific folder, using as many threads as you want.');

        $this->addArgument(
            'path',
            InputArgument::REQUIRED,
            'The path where to look for duplicates'
        );
        $this->addArgument(
            'threads-amount',
            InputArgument::OPTIONAL,
            'Amount of threads to use',
            4
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $threadsAmount = (int)$input->getArgument('threads-amount');
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        $io = new SymfonyStyle($input, $output);

        $io->section(sprintf("finding duplicates in %s", $path));

        $fileSystem = new FileSystem();
        $fileDataProvider = new FileDataProvider($path, $fileSystem);
        $fileDataProvider->initFilesList();
        $pool = new Pool($threadsAmount, FileHashWorker::class, [$fileDataProvider]);

        for ($i = 0; $i < $threadsAmount; $i++) {
            $pool->submit(new CalculateHashWork());
            $io->success('submitted a new task to the next worker');
        }

        $io->comment('Waiting for the threads to finish...');

        $pool->shutdown();

        $duplicates = new Duplicates();
        $dups = $duplicates->find((array)$fileDataProvider->getFiles());
        $io->section('Duplicates:');

        foreach ($dups as $hash => $files) {
            $io->title($hash);
            $io->listing($files);
        }
    }
}