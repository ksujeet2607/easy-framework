<?php

namespace Core\CLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('greet')
            ->setDescription('Greats a user.')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the user', 'World')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the greeting will be uppercase');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $greeting = "Hello $name!";

        if ($input->getOption('yell')) {
            $greeting = strtoupper($greeting);
        }

        $output->writeln($greeting);

        return Command::SUCCESS;

    }


}