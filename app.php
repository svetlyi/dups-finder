<?php

require __DIR__ . '/vendor/autoload.php';

use DupsFinder\Command\FindDuplicates;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new FindDuplicates());

$application->run();