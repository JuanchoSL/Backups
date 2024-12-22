<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Compressors;

use JuanchoSL\Backups\Contracts\CompressorInterface;

class DeflateCompressor implements CompressorInterface
{
    public function compress(string $text): string
    {
        return gzcompress($text);
    }
    public function decompress(string $text): string
    {
        return gzuncompress($text);
    }
}