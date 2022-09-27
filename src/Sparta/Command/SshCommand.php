<?php

namespace Sparta\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class SshCommand extends Command
{

    public function configure()
    {
        $this->setName('ssh')
            ->setDescription('SSH wrapper for magento-cloud')
            ->setHelp('help message TBD')
            ->addArgument('project', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment code', "production")
            ->addOption('executeCommand', 'c', InputArgument::OPTIONAL, 'Command to execute');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $processCommand = [
            'magento-cloud',
            'ssh',
            '--project=' . $input->getArgument('project'),
            '--environment=' . $input->getArgument('environment')
        ];
        $executeCommand = $input->getOption('executeCommand');
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