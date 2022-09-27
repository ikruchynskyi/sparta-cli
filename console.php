#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Sparta\Command\SshCommand;
define("APP_VERSION", 'v1.0.0');

$app = new Application('Sparta CLI App', APP_VERSION);
$app->add(new SshCommand);
$app->run();