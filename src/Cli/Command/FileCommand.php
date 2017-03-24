<?php
namespace Cli\Command;
//$question = new Question("What is your language?\n", 'english');

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class MainCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('file')
            ->addArgument('postedAdvertId');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $postedAdvertId = $input->getArgument('postedAdvertId');
        $helper = $this->getHelper('question');

        $question = new Question("What is your language?\n", 'english');

        $language = $helper->ask($input, $output, $question);

        $output->writeln('You chose '.$language);
    }
}