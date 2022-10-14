<?php

namespace Sparta\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Access log filter
 */
class AccessLogCommand extends Command
{
//207.46.13.6 - - [29/Sep/2022:03:15:16 +0000] "GET /no_en/bikes/road-gravel/atlas HTTP/1.1" 200 311488 "-" "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)"
    private $header = [
        "ip" => 'plain',
        1 => 'plain',
        2 => 'plain',
        "date" => 'date',
        "gmt" => 'plain',
        "path" => 'path',
        "status" => 'plain',
        "contentLength" => 'plain',
        9 => 'plain',
        "userAgent" => 'agent'
    ];

    /**
     * @return void
     */
    public function configure()
    {
        $this->setName('access:log')
            ->setDescription('Tool to filter data from access.log fiels');
//            ->addArgument('project', InputArgument::REQUIRED, 'Project ID')
//            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment code', "production")
//            ->addOption('query', 'query', InputArgument::OPTIONAL, 'DB query to execute');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $processCommand = [
//            'magento-cloud',
//            'sql',
//            '--project=' . $input->getArgument('project'),
//            '--environment=' . $input->getArgument('environment'),
//            '--relationship=' . $input->getArgument('relationship')
//        ];
//        $executeCommand = $input->getOption('query');
//        if ($executeCommand) {
//            $processCommand[] = $executeCommand;
//        }
//        $process = new Process($processCommand);
//        $process->run();
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
        $fileName = 'access.log';
        $rows = array_map(function($v){return str_getcsv($v, " ");}, file($fileName));
        $csv = [];
        foreach($rows as $row) {
            $row = array_combine(array_keys($this->header), $row);
            foreach ($row as $field => $value) {
                $handler = $this->header[$field] . "Handler";
                $row[$field] = $this->$handler($value);
            }
            $csv[] = $row;
        }
        var_dump($csv);die;
        $output->writeln('aa');

//        return $process->getExitCode();
    }

    /**
     * Do not process value
     *
     * @param $value
     * @return mixed
     */
    private function plainHandler($value)
    {
        return $value;
    }

    private function pathHandler($path) {
        return $path . "PATHHADNEL";
    }

    private function dateHandler($date) {
        return $date . "DATETET";
    }

    private function agentHandler($agent) {
        return $agent . "AGENTUS";
    }
}