<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\BooleanRule;

/**
 * BooleanRuleクラスのユニットテスト
 */
class BooleanRuleTest extends TestCase
{
    /**
     * 有効なboolean値のデータプロバイダ
     */
    public static function 有効なboolean値のデータプロバイダ(): \Iterator
    {
        yield 'boolean true' => [true];
        yield 'boolean false' => [false];
        yield '文字列 "1"' => ['1'];
        yield '文字列 "0"' => ['0'];
        yield '文字列 "true"' => ['true'];
        yield '文字列 "false"' => ['false'];
        yield '数値 1' => [1];
        yield '数値 0' => [0];
    }

    /**
     * 無効なboolean値のデータプロバイダ
     */
    public static function 無効なboolean値のデータプロバイダ(): \Iterator
    {
        yield '無効な文字列' => ['invalid'];
        yield '無効な数値' => [2];
        yield 'null値' => [null];
        yield '空配列' => [[]];
        yield '配列' => [[1, 2, 3]];
        yield 'オブジェクト' => [new \stdClass()];
        yield '空文字列' => [''];
        yield '文字列スペース' => [' '];
        yield '負の数値' => [-1];
        yield 'float値' => [1.5];
    }

    #[Test]
    #[DataProvider('有効なboolean値のデータプロバイダ')]
    public function 有効なboolean値の場合はtrueを返す(mixed $value): void
    {
        // テスト対象のインスタンスを作成
        $instance = new BooleanRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', $value, $parameters);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    #[DataProvider('無効なboolean値のデータプロバイダ')]
    public function 無効なboolean値の場合はfalseを返す(mixed $value): void
    {
        // テスト対象のインスタンスを作成
        $instance = new BooleanRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', $value, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }
}