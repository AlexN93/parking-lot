<?php

namespace Cli\Command;
//$question = new Question("What is your language?\n", 'english');

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Handler\ParkingLotHandler;

class FileCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('file')
            ->addArgument('input_file')
            ->addArgument('output_file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handler = new ParkingLotHandler();
        $input_file = $input->getArgument('input_file');
        $output_file = $input->getArgument('output_file');

        $input_handle = fopen($input_file, 'r');
        $output_handle = fopen($output_file, 'wb');
        if ($input_handle) {
            while (($line = fgets($input_handle)) !== false) {
                $outputData = $handler->command($line);
                $output->writeln($outputData['message']);
                fwrite($output_handle, $outputData['message'] . "\r\n");
            }
            fclose($input_handle);
            fclose($output_handle);
        } else {
            $output->writeln('Input file not found');
        }
    }
}