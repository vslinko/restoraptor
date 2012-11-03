<?php

namespace Restoraptor\Command;

use Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Command\Command;

use Symfony\Component\Process\ProcessBuilder;

class RunCommand extends Command
{
    protected function configure()
    {
        $this->setName('run');
        $this->addArgument('address', null, '', 'localhost:8000');
        $this->addOption('mongodb-server', null, InputOption::VALUE_REQUIRED, '', 'mongodb://localhost:27017');
        $this->addOption('mongodb-database-name', null, InputOption::VALUE_REQUIRED, '', 'morest');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("Server running on <info>%s</info>\n", $input->getArgument('address')));

        $builder = new ProcessBuilder(array(PHP_BINARY, '-S', $input->getArgument('address'), __DIR__ . '/../Resources/router.php'));
        $builder->setTimeout(null);
        $builder->setEnv('MONGODB_SERVER', $input->getOption('mongodb-server'));
        $builder->setEnv('MONGODB_DATABASE_NAME', $input->getOption('mongodb-database-name'));
        $builder->getProcess()->run(function ($type, $buffer) use ($output) {
            if (OutputInterface::VERBOSITY_VERBOSE === $output->getVerbosity()) {
                $output->write($buffer);
            }
        });
    }
}
