<?php

namespace Tests\Unit\Validationable\Rules;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use SplFileInfo;
use Tests\Unit\TestCase;
use Validationable\Rules\FileRule;

class FileRuleTest extends TestCase
{
    #[Test]
    public function ファイルパスが読める場合はtrueを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('file', __FILE__, $parameters);

        $this->assertTrue($actual, '存在するファイルパスが読める場合、true が返ってくるべきです。');
    }

    #[Test]
    public function ファイルパスが存在しない場合はfalseを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('file', '/non-existent-file.txt', $parameters);

        $this->assertFalse($actual, '存在しないファイルパスの場合、false が返ってくるべきです。');
    }

    #[Test]
    public function リソースが渡された場合はtrueを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $resource = fopen('php://temp', 'r');
        $actual = $instance->passes('file', $resource, $parameters);
        fclose($resource);

        $this->assertTrue($actual, 'リソースが渡された場合、true が返ってくるべきです。');
    }

    #[Test]
    public function SplFileInfoインスタンスがファイルの場合はtrueを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $splFileInfo = new SplFileInfo(__FILE__);
        $actual = $instance->passes('file', $splFileInfo, $parameters);

        $this->assertTrue($actual, 'SplFileInfo インスタンスがファイルの場合、true が返ってくるべきです。');
    }

    #[Test]
    public function LaravelFileインスタンスがファイルの場合はtrueを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $splFileInfo = new UploadedFile(__FILE__, basename(__FILE__));
        $actual = $instance->passes('file', $splFileInfo, $parameters);

        $this->assertTrue($actual, 'SplFileInfo インスタンスがファイルの場合、true が返ってくるべきです。');
    }

    #[Test]
    public function SplFileInfoインスタンスがファイルでない場合はfalseを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $splFileInfo = new SplFileInfo(__DIR__);
        $actual = $instance->passes('file', $splFileInfo, $parameters);

        $this->assertFalse($actual, 'SplFileInfo インスタンスがファイルでない場合、false が返ってくるべきです。');
    }

    #[Test]
    public function その他の値の場合はfalseを返す(): void
    {
        $instance = new FileRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('file', 123, $parameters);

        $this->assertFalse($actual, 'サポートされていない値が渡された場合、false が返ってくるべきです。');
    }
}