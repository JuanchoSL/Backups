<?php

namespace JuanchoSL\Backups\Tests\Unit;

use JuanchoSL\Backups\Engines\Compressors\BzipCompressor;
use JuanchoSL\Backups\Engines\Compressors\DeflateCompressor;
use JuanchoSL\Backups\Engines\Compressors\GzipCompressor;
use PHPUnit\Framework\TestCase;

class CompressionTest extends TestCase
{
    protected function providerLoginData(): array
    {
        return [
            'Bz2' => [
                new BzipCompressor
            ],
            'Gzip' => [
                new GzipCompressor
            ],
            'Deflate' => [
                new DeflateCompressor
            ]
        ];
    }

    /**
     * @dataProvider providerLoginData
     */
    public function testSizeAfterCompression($compressor)
    {
        $text = file_get_contents(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'README.md');
        $c = $compressor->compress($text);
        $this->assertLessThan(strlen($text), strlen($c));
        $c = $compressor->decompress($c);
        $this->assertEquals($text, $c);
    }
}