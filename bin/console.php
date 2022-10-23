#!/usr/bin/env php
<?php
require __DIR__.'/../vendor/autoload.php';

use A3F\App\Commands\ParserCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ParserCommand());
$application->run();