<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Packagers;

use JuanchoSL\Backups\Contracts\EnginesInterface;
use JuanchoSL\Exceptions\PreconditionRequiredException;

class ZipEngine implements EnginesInterface
{
    protected $engine;

    public function getExtension(): string
    {
        return 'zip';
    }

    public function setDestiny(string $destiny)
    {
        if (!extension_loaded('zip')) {
            throw new PreconditionRequiredException("The extension ZIP is not available");
        }
        $this->engine = new \ZipArchive;
        $this->engine->open($destiny, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        //$this->engine->setArchiveComment(sprintf("Backup {$destiny} created %s", date("Y-m-h H:i:s")));
    }

    public function addEmptyDir(string $internal_path): bool
    {
        return $this->engine->addEmptyDir($internal_path);
    }

    public function addFile(string $real_path, string $internal_path)
    {
        $this->engine->addFile($real_path, $internal_path);
    }

    public function setComment(string $comment)
    {
        $this->engine->setArchiveComment($comment);
    }

    public function close()
    {
        $this->engine->close();
    }
}