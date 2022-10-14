<?php

namespace Sparta\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Enable/disable search debug on Magento Cloud instance
 */
class SearchDebugEnableCommand extends Command
{

    const COMMAND_NAME = 'search:debug:enable';

    const GET_SEARCH_ENGINE = 'bin/magento config:show catalog/search/engine';

    const IS_LS_ENABLED = 'bin/magento module:status Magento_LiveSearch';

    const ELASTICSEARCH = 1;

    const LIVESEARCH = 2;

    /**
     * @return void
     */
    public function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Enable log CURL requests to search engines')
            ->addArgument('project', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment code', "production")
            ->addOption('executeCommand', 'c', InputArgument::OPTIONAL, 'Command to execute over SSH'); // TODO: can't be renamed r removed
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $nullOutput = new NullOutput;
        switch ($this->determineSearchEngine($input, $nullOutput)) {
            case self::ELASTICSEARCH:
                $output->writeln("// patch ES adapter");
                break;
            case self::LIVESEARCH:
                $output->writeln("// patch LS adapter");
                break;
        }

        return 0;

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    private function determineSearchEngine(InputInterface $input, OutputInterface $output)
    {
        $executor = new SshCommand;
        $input->setOption('executeCommand', self::GET_SEARCH_ENGINE);
        $executor->execute($input, $output);

        $input->setOption('executeCommand', self::IS_LS_ENABLED);
        $executor->execute($input, $output);

        $isESUsed = strpos($executor->getExecutionStack()[self::GET_SEARCH_ENGINE]['result'], 'elastic') !== false;
        $isLSEnabled = strpos($executor->getExecutionStack()[self::GET_SEARCH_ENGINE]['result'], 'enabled') !== false;

        return $isESUsed && !$isLSEnabled ? self::ELASTICSEARCH : self::LIVESEARCH;
    }
}