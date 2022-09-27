<?php

namespace Sparta\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * CLI wrapper for magento-cloud ssh command.
 */
class PatchCheckCommand extends Command
{

    /**
     * @return void
     */
    public function configure()
    {
        $this->setName('patch:check')
            ->setDescription('Check patch (dry-run) file against Magento cloud environment')
            ->addArgument('patchPath',  InputArgument::REQUIRED, 'Absolute path to the patch file')
            ->addArgument('project', InputArgument::REQUIRED, 'Project ID')
            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment code', "production");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('patchPath');
        if (!file_exists($filePath)) {
            throw new \Exception("Patch file $filePath doesn't exist");
        }

        $processCommand = [
            'magento-cloud',
            'ssh',
            '--project=' . $input->getArgument('project'),
            '--environment=' . $input->getArgument('environment')
        ];
        $inlineCheckPattern = "cat << 'EOF' | patch -p1 --dry-run
        %s
        EOF";

        $checkCommand = sprintf($inlineCheckPattern, file_get_contents($filePath));
        $processCommand[] = $checkCommand;


        $process = new Process($processCommand);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln($process->getOutput());

        return $process->getExitCode();
    }
}