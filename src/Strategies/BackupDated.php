<?php

namespace JuanchoSL\Backups\Strategies;

class BackupDated extends AbstractBackup
{

    protected function calculateIndex(string $destination): string
    {
        $file_data = pathinfo($destination);
        return $file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . date("YmdHis") . "." . $file_data['extension'];
    }
}