<?php

namespace JuanchoSL\Backups\Contracts;

use JuanchoSL\Backups\Enums\RepositoryEnum;
use JuanchoSL\Backups\Enums\StrategyEnum;

interface Config
{

    public function setNumCopies(int $num);
    public function getNumCopies(): int;
    public function setOrigin(string $directory);
    public function getOrigin(): string;
    public function setDestiny(string $directory);
    public function getDestiny(): string;
    public function setStrategy(StrategyEnum $strategy);
    public function getStrategy(): StrategyEnum;
    public function setRepository(RepositoryEnum $strategy);
    public function getRepository(): RepositoryEnum;
}