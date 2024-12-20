<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Contracts;

interface CompressorInterface
{
    /**
     * Compress a text using the selected compressor
     * @param string $text Text to compress
     * @return string the compressed text
     */
    public function compress(string $text): string;

    /**
     * Decompress a text using the selected compressor
     * @param string $text The compressed text
     * @return string The decompressed text
     */
    public function decompress(string $text): string;
}