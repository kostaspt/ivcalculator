<?php

namespace IVCalculator\Console\Commands;

use IVCalculator\IVCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends Command
{
    protected function configure()
    {
        $this->setName('analyze')
            ->setDescription('Analyzes a pokemon.');

        $this->addArgument('nameOrId', InputArgument::REQUIRED, 'The Pokemon\'s name or ID')
            ->addArgument('CP', InputArgument::REQUIRED)
            ->addArgument('HP', InputArgument::REQUIRED)
            ->addArgument('dustCost', InputArgument::REQUIRED, 'Stardust needed for power up')
            ->addArgument('neverUpgraded', InputArgument::OPTIONAL, ' Was powered up before?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $results = (new IVCalculator())->evaluate(
            $input->getArgument('nameOrId'),
            (int) $input->getArgument('CP'),
            (int) $input->getArgument('HP'),
            (int) $input->getArgument('dustCost'),
            $input->getArgument('neverUpgraded') == 'true' ? true : false
        );

        // Title
        $output->writeln('=========================');
        $output->writeln(
            sprintf(
                '%s (%.0f%%)',
                $results->get('name'),
                $results->get('perfection')->get('average') * 100
            )
        );
        $output->writeln("=========================\n");

        // IVs
        (new Table($output))
            ->setHeaders(['Perfection', 'Attack IV', 'Defense IV', 'Stamina IV', 'Level'])
            ->setRows($results->get('ivs')->map(function ($iv) {
                return [
                    sprintf('%.0f%%', $iv->perfection * 100),
                    $iv->attackIV,
                    $iv->defenseIV,
                    $iv->staminaIV,
                    $iv->level,
                ];
            })->toArray())->render();
    }
}
