<?php

namespace JuanchoSL\Backups\Strategies;

class BackupNumRotate extends AbstractBackup
{

    protected function calculateIndex(string $destination): string
    {
        $file_data = pathinfo($destination);
        for ($anexo = 1; $anexo <= $this->num_backups; $anexo++) {
            if (!file_exists($file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo . "." . $file_data['extension'])) {
                break;
            } elseif (
                $anexo > 1 && file_exists($file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo - 1 . "." . $file_data['extension']) &&
                filemtime($file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo . "." . $file_data['extension']) < filemtime($file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo - 1 . "." . $file_data['extension'])
            ) {
                break;
            } elseif ($this->num_backups == $anexo) {
                $anexo = 1;
                break;
            }
        }
        return $file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_" . $anexo . "." . $file_data['extension'];
    }
}