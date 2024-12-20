<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Repositories\Compressors;

use JuanchoSL\Backups\Contracts\CompressorInterface;

class ZlibCompressor implements CompressorInterface
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