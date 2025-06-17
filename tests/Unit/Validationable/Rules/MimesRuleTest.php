<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\MimesRule;

class MimesRuleTest extends TestCase
{
    /**
     * クラスの説明:
     * `MimesRule`クラスは、ファイルが指定されたMIMEタイプであるかどうかを検証します。
     *
     * メソッドの説明:
     * `passes`メソッドは、指定されたファイルのMIMEタイプが引数で提供されたリスト内にあるかどうかを確認します。
     */

    #[Test]
    public function パラメータに引数がない場合に例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Mimes rule requires at least one argument');

        $instance = new MimesRule();
        $parameters = $this->createParameter([]);
        $instance->passes('attribute', 'value', $parameters, []);
    }

    #[Test]
    public function ファイルが存在せずに失敗する(): void
    {
        $instance = new MimesRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', '/invalid/path/to/file', $parameters, ['png']);

        $this->assertFalse($actual, 'ファイルが存在しない場合のテストに失敗しました');
    }

    #[Test]
    public function ファイルのMIMEタイプがリストに含まれている場合成功する(): void
    {
        $instance = new MimesRule();
        $parameters = $this->createParameter([]);

        $filePath = __DIR__ . '/dummy/Blank.jpg';


        $actual = $instance->passes('attribute', $filePath, $parameters, ['png', 'jpeg']);


        $this->assertTrue($actual, 'MIMEタイプがリストに含まれている場合のテストに失敗しました');
    }

}