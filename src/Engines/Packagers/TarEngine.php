<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Packagers;

use JuanchoSL\Backups\Contracts\EnginesInterface;

class TarEngine implements EnginesInterface
{
    protected \PharData $engine;
    protected $destiny;
    public function getExtension(): string
    {
        return 'tar';
    }

    public function setDestiny(string $destiny)
    {
        if (!file_exists(dirname($destiny))) {
            mkdir(dirname($destiny));
        }
        $this->destiny = $destiny;
        $this->engine = new \PharData($destiny);
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
    }


    public function setComment(string $comment)
    {
        $this->engine->setMetadata(['comment' => $comment]);
    }

    public function close()
    {
        $this->engine->stopBuffering();
        $this->engine->compress(\Phar::GZ);
        //unlink($this->destiny);
        //$this->engine->convertToData(\Phar::TAR, \Phar::GZ, '.tar.bz');
    }
}