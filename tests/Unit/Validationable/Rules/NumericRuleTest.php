<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\NumericRule;

class NumericRuleTest extends TestCase
{
    #[Test]
    public function 数値の時にTrueが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 数値文字列でテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => '123']));
        // 結果を検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 整数の時にTrueが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 整数でテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => 123]));
        // 結果を検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 小数の時にTrueが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 小数でテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => '123.45']));
        // 結果を検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 負の数値の時にTrueが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 負の数値でテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => '-123']));
        // 結果を検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function ゼロの時にTrueが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // ゼロでテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => '0']));
        // 結果を検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 存在しないキーの時にFalseが返る(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 存在しないキーでテスト実行
        $actual = $instance->passes('invalidKey', $this->createParameter(['test' => '123']));
        // 結果を検証
        $this->assertFalse($actual);
    }

    #[Test]
    #[DataProvider('非数値データProvider')]
    public function 数値でないデータの時にFalseが返る(mixed $value, string $message): void
    {
        // テスト対象のインスタンスを作成
        $instance = new NumericRule();
        // 非数値データでテスト実行
        $actual = $instance->passes('test', $this->createParameter(['test' => $value]));
        // 結果を検証
        $this->assertFalse($actual, $message);
    }

    /**
     * 非数値データのテストケースを提供
     */
    public static function 非数値データProvider(): array
    {
        return [
            ['abc', '文字列'],
            ['123abc', '数値が含まれる文字列'],
            ['', '空文字'],
            [null, 'null値'],
            [[], '配列'],
            [true, 'boolean値'],
            ['12.34.56', '複数の小数点'],
            [' 123 ', '前後にスペースがある数値'],
        ];
    }
}