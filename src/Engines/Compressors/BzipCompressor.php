<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Repositories\Compressors;

use JuanchoSL\Backups\Contracts\CompressorInterface;

class BzipCompressor implements CompressorInterface
{
    public function compress(string $text): string
    {
        return bzcompress($text);
    }
    public function decompress(string $text): string
    {
        return bzdecompress($text);
    }
}