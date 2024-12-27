<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Commands;

use JuanchoSL\Backups\Engines\Packagers\PharEngine;
use JuanchoSL\Backups\Engines\Packagers\TarEngine;
use JuanchoSL\Backups\Engines\Packagers\ZipEngine;
use JuanchoSL\Backups\Strategies\BackupDated;
use JuanchoSL\Backups\Strategies\BackupUnique;
use JuanchoSL\Terminal\Command;
use JuanchoSL\Terminal\Contracts\InputInterface;
use JuanchoSL\Terminal\Enums\InputArgument;
use JuanchoSL\Terminal\Enums\InputOption;

class BackupCommand extends Command
{

    public function getName(): string
    {
        return "create";
    }

    protected function configure(): void
    {
        $this->addArgument('origin', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('destiny', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('format', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('excluded', InputArgument::OPTIONAL, InputOption::MULTI);
        $this->addArgument('copies', InputArgument::OPTIONAL, InputOption::SINGLE);
        $this->addArgument('basename', InputArgument::OPTIONAL, InputOption::SINGLE);
    }

    protected function execute(InputInterface $input): int
    {
        switch ($input->getArgument('format')) {
            case 'zip':
                $engine = new ZipEngine();
                break;
            case 'tar':
                $engine = new TarEngine();
                break;
            case 'phar':
                $engine = new PharEngine();
                break;
        }
        $parent = $input->getArgument('origin');

        $obj = ($input->hasArgument('copies')) ? new BackupDated() : new BackupUnique;
        $obj->setEngine($engine);
        $obj->setDestinationFolder($parent . DIRECTORY_SEPARATOR . $input->getArgument('destiny'));
        if ($input->hasArgument('excluded')) {
            foreach ($input->getArgument('excluded') as $excluded) {
                $obj->addExcludedDir($parent . DIRECTORY_SEPARATOR . $excluded);
            }
        }
        if ($input->hasArgument('copies')) {
            $obj->setNumBackups((int) $input->getArgument('copies'));
        }
        $basename = $input->hasArgument('basename') ? $input->getArgument('basename') : null;
        $this->write($obj->pack($parent, $basename));
        return 0;
    }
}