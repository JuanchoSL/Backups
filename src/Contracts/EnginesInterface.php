<?php

namespace JuanchoSL\Backups\Contracts;

interface EnginesInterface
{
    public function getExtension(): string;
    public function setDestiny(string $final_path);
    public function setComment(string $comment);
    public function addFile(string $real_path, string $internal_path);
    public function addEmptyDir(string $internal_path): bool;
    public function close();
}