<?php

namespace JuanchoSL\Backups\Strategies;

class BackupNumIncremental extends AbstractBackup
{

    protected function calculateIndex(string $destination): string
    {
        $files = $this->readBackups($destination);
        if (!empty($files)) {
            arsort($files);
        }
        $last = current($files);
        $file_data = pathinfo($destination);
        if (empty($last)) {
            $anexo = 1;
        } else {
            $file_last_data = pathinfo($last, PATHINFO_FILENAME);
            $anexo = @ltrim(str_replace($file_data['filename'], '', $file_last_data), '_') + 1;
        }
        return $file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo . "." . $file_data['extension'];
    }
}