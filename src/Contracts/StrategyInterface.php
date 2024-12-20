<?php

namespace JuanchoSL\Backups\Contracts;

use JuanchoSL\Backups\Contracts\EnginesInterface;

interface StrategyInterface
{

    /**
     * Set the desired engine in order to package the origin
     * @param EnginesInterface $engine The desired packager engine
     * @return void
     */
    public function setEngine(EnginesInterface $engine): static;

    /**
     * Set the destination folder for the resultant file
     * @param string $destination_folder The destination folder
     * @return void
     */
    public function setDestinationFolder(string $destination_folder): static;

    /**
     * Set how many copies needs to mantain into the destination folder
     * @param int $num_backups The num of persistent backups
     * @return void
     */
    public function setNumBackups(int $num_backups): static;

    /**
     * Add a folder in order to exclude into the backup
     * @param string $excluded The excluded folder
     * @return void
     */
    public function addExcludedDir(string $excluded): static;

    /**
     * Run the pack and create the backup
     * @param string $name Original folder to backup
     * @param mixed $pack_basename The base file name, without extension and without counter, it will be appened after
     * @return string The file name of the backup result file
     */
    public function pack(string $name, ?string $pack_basename = null): string;
}