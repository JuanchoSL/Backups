<?php

namespace JuanchoSL\Backups\Tests\Unit;

use JuanchoSL\Backups\Contracts\EnginesInterface;
use JuanchoSL\Backups\Engines\Packagers\PharEngine;
use JuanchoSL\Backups\Engines\Packagers\TarEngine;
use JuanchoSL\Backups\Engines\Packagers\ZipEngine;
use PHPUnit\Framework\TestCase;

class PackagingTest extends TestCase
{
    protected function providerLoginData(): array
    {
        return [
            'zip' => [
                new ZipEngine
            ],
            'tar' => [
                new TarEngine
            ],
            'phar' => [
                new PharEngine
            ]
        ];
    }

    /**
     * @dataProvider providerLoginData
     */
    public function testPackaging(EnginesInterface $compressor)
    {
        $destination = sys_get_temp_dir();
        $result_file = $destination . DIRECTORY_SEPARATOR . 'test_' . date("Ymd") . "." . $compressor->getExtension();
        $this->assertFileDoesNotExist($result_file);
        $compressor->setDestiny($result_file);
        $compressor->addFile(__FILE__, pathinfo(__FILE__, PATHINFO_FILENAME));
        $compressor->close();
        $this->assertFileExists($result_file);
        unlink($result_file);
        foreach (['gz', 'bz'] as $ext) {
            if (file_exists($result_file . '.' . $ext)) {
                unlink($result_file . '.' . $ext);
            }
        }
    }
}