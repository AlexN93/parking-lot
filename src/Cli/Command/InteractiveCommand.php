<?php
namespace Cli\Command;
//$question = new Question("What is your language?\n", 'english');

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use AppBundle\Handler\ParkingLotHandler;

class InteractiveCommand extends Command
{

//    private $array = array(1,2,3,4);

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

//        array_push($this->array, 5);

        $outputData = $handler->command($input);
        $output->writeln('Output:');
        $output->writeln($outputData['message']);
    }




}