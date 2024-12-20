<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Packagers;

use JuanchoSL\Backups\Contracts\EnginesInterface;

class PharEngine implements EnginesInterface
{
    protected \Phar $engine;

    public function getExtension(): string
    {
        return 'phar';
    }

    public function setDestiny(string $destiny)
    {
        if (!file_exists(dirname($destiny))) {
            mkdir(dirname($destiny));
        }
        $this->engine = new \Phar($destiny);
        $this->engine->startBuffering();
    }


    public function addEmptyDir(string $internal_path): bool
    {
        $this->engine->addEmptyDir($internal_path);
        return true;
    }

    public function addFile(string $real_path, string $internal_path)
    {
        //$this->engine->addFromString(gzcompress(file_get_contents($real_path), 9), $internal_path);
        $this->engine->addFile($real_path, $internal_path);
        //$this->engine[$internal_path]->compress(\Phar::GZ);
    }

    public function setComment(string $comment)
    {
        $this->engine->setMetadata($comment);
    }

    public function close()
    {
        $this->engine->stopBuffering();
        $this->engine->compressFiles(\Phar::BZ2);
        $this->engine->convertToData(\Phar::TAR, null, '.tar.bz');
        //$this->engine->convertToData(\Phar::TAR, \Phar::BZ2, '.tar.bz');
    }
}