<?php

declare(strict_types=1);

namespace App;

use JuanchoSL\Backups\Engines\Packagers\ZipEngine;
use JuanchoSL\Backups\Strategies\BackupNumIncremental;
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
        $this->addArgument('excluded', InputArgument::OPTIONAL, InputOption::MULTI);
        $this->addArgument('copies', InputArgument::OPTIONAL, InputOption::SINGLE);
    }

    protected function execute(InputInterface $input): int
    {
        $parent = $input->getArgument('origin');
        $obj = new BackupNumIncremental();
        $obj->setNumBackups((int) $input->getArgument('copies'));
        $obj->setEngine(new ZipEngine());
        $obj->setDestinationFolder($parent . DIRECTORY_SEPARATOR . $input->getArgument('destiny'));
        foreach($input->getArgument('excluded') as $excluded){
            $obj->addExcludedDir($parent . DIRECTORY_SEPARATOR . $excluded);
        }
        $this->write($obj->pack($parent));
        return 0;
    }
}