# Backup

## Description

Little methods collection in order to create distincts type of backups

## Install
```bash
composer require juanchosl/backups
composer update
```

## Packagers

First, you need to select the desired final file type in order to backup your files and folders, can use:

- ZipRepository
- TarRepository
- PharRepository

## Compression

Aditionally, we have available some compression systems in order to use with other needs

- Bzip
- Gzip
- Lzf
- Zlib

## Strategies

The Backup library, can rename the result file in order to mantain some copies, we can use

- Datetime in format YYYYmmddHHiiss
- Incremental number from 1 to N
- Rotate number, from 1 to N and restart from 1


## How to use

```php
use JuanchoSL\Backups\Strategies\BackupNumIncremental;
use JuanchoSL\Backups\Engines\Packagers\ZipEngine;

$parent = dirname(__DIR__, 1);
$obj = new BackupNumIncremental()
$obj->setNumBackups(2)
    ->setEngine(new ZipEngine())
    ->setDestinationFolder($parent . DIRECTORY_SEPARATOR . 'backups')
    ->addExcludedDir($parent . DIRECTORY_SEPARATOR . 'backups')
    ->addExcludedDir($parent . DIRECTORY_SEPARATOR . 'vendor');
$obj->pack($parent);
```