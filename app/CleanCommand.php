<?php

declare(strict_types=1);

namespace App;

use JuanchoSL\Backups\Strategies\BackupNumIncremental;
use JuanchoSL\Terminal\Command;
use JuanchoSL\Terminal\Contracts\InputInterface;
use JuanchoSL\Terminal\Enums\InputArgument;
use JuanchoSL\Terminal\Enums\InputOption;

class CleanCommand extends Command
{

    public function getName(): string
    {
        return "clean";
    }

    protected function configure(): void
    {
        $this->addArgument('destiny', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('copies', InputArgument::REQUIRED, InputOption::SINGLE);
    }

    protected function execute(InputInterface $input): int
    {
        $obj = new BackupNumIncremental();
        $obj->setNumBackups((int) $input->getArgument('copies'));
        $this->write($obj->cleanOlders($input->getArgument('destiny')));
        return 0;
    }
}