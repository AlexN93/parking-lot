<?php

namespace Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use AppBundle\Handler\ParkingLotHandler;

class InteractiveCommand extends Command
{
    protected function configure()
    {
        $this->setName('interactive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handler = new ParkingLotHandler();
        while(true) {
            $this->askQuestion($input, $output, $handler);
        }
    }

    private function askQuestion(InputInterface $input, OutputInterface $output, $handler) {
        $helper = $this->getHelper('question');
        $question = new Question("Input:\n", 'english');
        $input = $helper->ask($input, $output, $question);
        $outputData = $handler->command($input);
        $output->writeln('Output:');
        $output->writeln($outputData['message']);
    }
}