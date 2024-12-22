<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Engines\Compressors;

use JuanchoSL\Backups\Contracts\CompressorInterface;

class LzfCompressor implements CompressorInterface
{
    public function compress(string $text): string
    {
        return lzf_compress($text);
    }
    public function decompress(string $text): string
    {
        return lzf_decompress($text);
    }
}