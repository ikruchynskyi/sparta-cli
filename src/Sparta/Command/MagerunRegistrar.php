<?php
namespace Sparta\Command;

use N98\MagerunBootstrap;

/**
 * Get list of Magerun commands
 */
class MagerunRegistrar {

    /**
     * @return array
     */
    public function getCommands() {
        $n98Application = MagerunBootstrap::createApplication();
        $n98Application->init();
        return $n98Application->getConfig()['commands']['customCommands'];
    }
}