<?php

namespace JuanchoSL\Backups\Strategies;

class BackupUnique extends AbstractBackup
{

    protected function calculateIndex(string $destination): string
    {
        return $destination;
    }
}