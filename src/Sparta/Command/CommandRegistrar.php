<?php
namespace Sparta\Command;
use Symfony\Component\ClassLoader\ClassMapGenerator;

/**
 * CLI commands registrar
 */
class CommandRegistrar {

    /**
     * @var array
     */
    private $commands = [];

    /**
     *
     */
    public function __construct()
    {
        $classes = ClassMapGenerator::createMap(__DIR__);
        foreach ($classes as $class => $path) {
            if (strpos($path, 'Command.php') !== false) {
                $this->commands[] = new $class;
            }
        }
    }

    /**
     * @return array
     */
    public function getCommands() {
        return $this->commands;
    }
}