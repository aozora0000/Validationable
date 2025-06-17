<?php

namespace Tests\Unit\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use SplFileInfo;
use Tests\Unit\TestCase;
use Validationable\Rules\ImageRule;

class ImageRuleTest extends TestCase
{
    #[Test]
    // 存在する画像ファイルが検証に合格することを確認します
    public function 画像ファイルのパスが成功する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $instance->passes('image', $value, $parameters);

        $this->assertTrue($actual, 'JPEG画像ファイルが正しく検証されませんでした。');
    }

    #[Test]
    // 存在しないパスが検証に失敗することを確認します
    public function 存在しないファイルのパスが失敗する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $value = '/non-existent/image.png';
        $actual = $instance->passes('image', $value, $parameters);

        $this->assertFalse($actual, '存在しないファイルパスが誤って成功しました。');
    }

    #[Test]
    // テキストファイルが検証に失敗することを確認します
    public function テキストファイルが失敗する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $value = __FILE__;
        $actual = $instance->passes('image', $value, $parameters);

        $this->assertFalse($actual, 'テキストファイルが誤って成功しました。');
    }

    #[Test]
    // SplFileInfo経由で画像ファイルが成功することを確認します
    public function SplFileInfo経由で画像ファイルが成功する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $filePath = __DIR__ . '/dummy/Blank.jpg';

        $value = new SplFileInfo($filePath);
        $actual = $instance->passes('image', $value, $parameters);

        $this->assertTrue($actual, 'SplFileInfo経由のJPEG画像ファイルが正しく検証されませんでした。');
    }

    #[Test]
    // リソース型で画像として正しいファイルストリームが成功するか確認します
    public function リソース型で画像ファイルが成功する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $filePath = __DIR__ . '/dummy/Blank.jpg';
        $value = fopen($filePath, 'rb');
        $actual = $instance->passes('image', $value, $parameters);
        $this->assertTrue($actual, 'リソース型の画像ストリームが正しく検証されませんでした。');
    }

    #[Test]
    // 画像ファイルではないリソースが失敗することを確認します
    public function 画像ファイルではないリソースが失敗する(): void
    {
        $instance = new ImageRule();
        $parameters = $this->createParameter([]);
        $filePath = __FILE__;
        $value = fopen($filePath, 'rb');
        $actual = $instance->passes('image', $value, $parameters);

        $this->assertFalse($actual, '画像ファイルではないリソースが誤って成功しました。');
    }
}