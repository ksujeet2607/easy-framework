<?php

namespace Core\CLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MaintenanceModeCommand extends Command
{
    protected static $defaultName = 'maintenance';

    private string $lockFile;

    public function __construct()
    {
        parent::__construct();

        $this->lockFile = base_path() . '/storage/framework/maintenance.lock';
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Enable or disable maintenance mode')
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'Action to perform: on | off | status'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = strtolower($input->getArgument('action'));

        return match ($action) {
            'on'     => $this->enable($output),
            'off'    => $this->disable($output),
            'status' => $this->status($output),
            default  => $this->invalid($output),
        };
    }

    private function enable(OutputInterface $output): int
    {
        if (file_exists($this->lockFile)) {
            $output->writeln('<comment>Maintenance mode is already enabled.</comment>');
            return Command::SUCCESS;
        }

        $dir = dirname($this->lockFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents(
            $this->lockFile,
            json_encode([
                'enabled_at' => date('Y-m-d H:i:s'),
                'enabled_by' => get_current_user(),
            ], JSON_PRETTY_PRINT)
        );

        $output->writeln('<info>Maintenance mode enabled.</info>');
        return Command::SUCCESS;
    }

    private function disable(OutputInterface $output): int
    {
        if (!file_exists($this->lockFile)) {
            $output->writeln('<comment>Maintenance mode is not enabled.</comment>');
            return Command::SUCCESS;
        }

        unlink($this->lockFile);

        $output->writeln('<info>Maintenance mode disabled.</info>');
        return Command::SUCCESS;
    }

    private function status(OutputInterface $output): int
    {
        if (!file_exists($this->lockFile)) {
            $output->writeln('<info>Maintenance mode is OFF.</info>');
            return Command::SUCCESS;
        }

        $data = json_decode(file_get_contents($this->lockFile), true);

        $output->writeln('<error>Maintenance mode is ON.</error>');
        if ($data) {
            $output->writeln('Enabled at : ' . ($data['enabled_at'] ?? 'N/A'));
            $output->writeln('Enabled by : ' . ($data['enabled_by'] ?? 'N/A'));
        }

        return Command::SUCCESS;
    }

    private function invalid(OutputInterface $output): int
    {
        $output->writeln('<error>Invalid action. Use: on | off | status</error>');
        return Command::FAILURE;
    }
}
