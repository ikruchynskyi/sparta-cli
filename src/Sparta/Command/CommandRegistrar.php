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
        $magerunRegistrar = new MagerunRegistrar;
        foreach ($magerunRegistrar->getCommands() as $n98Class) {
            $this->commands[] = new $n98Class;
        }
        $classes = ClassMapGenerator::createMap(__DIR__);
        foreach ($classes as $class => $path) {
            if (strpos($path, 'Command.php') !== false) {
                $this->commands[] = new $class;
            }
        }
//        var_dump($this->commands);die;
    }

    /**
     * @return array
     */
    public function getCommands() {
        return $this->commands;
    }
}