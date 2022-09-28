<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sparta\Command\CommandRegistrar;
use Sparta\Application;

define("APP_VERSION", 'v1.0.0');

ini_set('display_errors', 1);
date_default_timezone_set('UTC');
ini_set('precision', 14);
ini_set('serialize_precision', 14);

/* PHP version validation */
if (PHP_SAPI !== 'cli') {
    http_response_code(503);
    exit(1);
}

class Bootstrap {

    /**
     * @return Application
     */
    public static function getApplication()
    {
        $app = new Application('Sparta CLI App', APP_VERSION);

        $n98autoload = require_once __DIR__ . '/vendor/netz98/n98-magerun2/vendor/autoload.php';
        $autoload = require_once __DIR__ . '/vendor/autoload.php';
        $app->setAutoloader($autoload);

        $app->init();
        $commandRegistrar = new CommandRegistrar;
        $app->addCommands($commandRegistrar->getCommands());
        return $app;
    }
}
