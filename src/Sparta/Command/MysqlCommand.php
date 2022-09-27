<?php

namespace Sparta\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class MysqlCommand extends Command
{

    public function configure()
    {
        $this->setName('sql')
            ->setDescription('SSH mysql wrapper for magento-cloud')
            ->addArgument('project', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment code', "production")
            ->addArgument('relationship', InputArgument::OPTIONAL, 'Relationship', "database")
            ->addOption('sql', 'sql', InputArgument::OPTIONAL, 'Command to execute');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $processCommand = [
            'magento-cloud',
            'sql',
            '--project=' . $input->getArgument('project'),
            '--environment=' . $input->getArgument('environment'),
            '--relationship=' . $input->getArgument('relationship')
        ];
        $executeCommand = $input->getOption('sql');
        if ($executeCommand) {
            $processCommand[] = $executeCommand;
        }
        $process = new Process($processCommand);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln($process->getOutput());

        return $process->getExitCode();
    }
}