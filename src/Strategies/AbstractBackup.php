<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Strategies;

use JuanchoSL\Backups\Contracts\EnginesInterface;
use JuanchoSL\Backups\Contracts\StrategyInterface;
use JuanchoSL\Exceptions\NotFoundException;

abstract class AbstractBackup implements StrategyInterface
{
    protected int $num_backups = 0;
    protected array $excluded = [];
    protected EnginesInterface $engine;
    protected ?string $destination_folder = null;

    abstract protected function calculateIndex(string $destination): string;

    public function setEngine(EnginesInterface $engine): static
    {
        $this->engine = $engine;
        return $this;
    }

    public function setDestinationFolder(string $destination_folder): static
    {
        $this->destination_folder = $destination_folder;
        return $this;
    }

    public function setNumBackups(int $num_backups): static
    {
        $this->num_backups = $num_backups;
        return $this;
    }

    public function addExcludedDir(string $excluded): static
    {
        $this->excluded[] = realpath(rtrim($excluded, DIRECTORY_SEPARATOR));
        return $this;
    }

    public function pack(string $name, ?string $pack_basename = null): string
    {
        if (!file_exists($name)) {
            throw new NotFoundException("The target {$name} does not exists");
        }
        $name = realpath($name);
        if (is_null($pack_basename)) {
            $pack_basename = basename($name);
        }
        $this->destination_folder = (is_null($this->destination_folder)) ? dirname($name, 1) : $this->destination_folder;
        if (!file_exists($this->destination_folder)) {
            mkdir($this->destination_folder, 0777, true);
        }
        $pack_basename = $this->destination_folder . DIRECTORY_SEPARATOR . $pack_basename . '.' . $this->engine->getExtension();
        $pack_name = $this->calculateIndex($pack_basename);
        if (file_exists($pack_name)) {
            unlink($pack_name);
        }
        $this->engine->setDestiny($pack_name);
        $this->engine->setComment(sprintf("Backup of %s - %s", $name, date("Y-m-d H:i:s")));
        $this->readDirectory($name, $name);
        $this->engine->close();
        $this->cleanOlders($pack_basename);
        return $pack_name;
    }

    protected function readDirectory($name, $remove): bool
    {
        if (!in_array($name, $this->excluded)) {
            $contents = glob($name . DIRECTORY_SEPARATOR . "{.[!.],}*", GLOB_BRACE);
            if (empty($contents)) {
                $this->engine->addEmptyDir(str_replace($remove . DIRECTORY_SEPARATOR, '', $name));
            } else {
                foreach ($contents as $filename) {
                    if (!is_dir($filename)) {
                        if ($filename != "." && $filename != "..") {
                            $this->engine->addFile($filename, str_replace($remove . DIRECTORY_SEPARATOR, '', $filename));
                        }
                    } else {
                        $this->readDirectory($filename, $remove);
                    }
                }
            }
        }
        return true;
    }

    protected function readBackups(string $pack_name): array
    {
        $files = [];
        $file_data = pathinfo($pack_name);
        foreach (glob($file_data['dirname'] . DIRECTORY_SEPARATOR . $file_data['filename'] . "_*." . $file_data['extension']) as $filename) {
            if (!is_dir($filename)) {
                if ($filename != "." && $filename != "..") {
                    $files[filemtime($filename)] = $filename;
                }
            }
        }
        return $files;
    }

    public function cleanOlders(string $pack_name): int
    {
        $removed = 0;
        if ($this->num_backups > 0) {
            $files = $this->readBackups($pack_name);
            if (!empty($files)) {
                ksort($files);
            }
            $count = count($files);
            if ($count > $this->num_backups) {
                $olders = array_slice($files, 0, $count - $this->num_backups);
                foreach ($olders as $older) {
                    if (unlink($older)) {
                        $removed++;
                    }
                }
            }
        }
        return $removed;
    }

    public function purge(string $pack_name): int
    {
        $removed = 0;
        $files = $this->readBackups($pack_name);
        foreach ($files as $older) {
            if (unlink($older)) {
                $removed++;
            }
        }
        return $removed;
    }
}