<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Compressors;

use JuanchoSL\Backups\Contracts\CompressorInterface;

class GzipCompressor implements CompressorInterface
{
    public function compress(string $text): string
    {
        return gzencode($text);
    }
    public function decompress(string $text): string
    {
        return gzdecode($text);
    }
}