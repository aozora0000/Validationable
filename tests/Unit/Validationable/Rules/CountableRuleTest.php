<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\CountableRule;

/**
 * CountableRuleクラスのユニットテスト
 */
class CountableRuleTest extends TestCase
{
    #[Test]
    public function 配列が渡された場合はtrueを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', [1, 2, 3], $parameters);
        
        // 結果検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 空の配列が渡された場合はtrueを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', [], $parameters);
        
        // 結果検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function Countableインターフェースを実装したオブジェクトが渡された場合はtrueを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // Countableオブジェクト作成
        $countableObject = new \ArrayObject([1, 2, 3]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', $countableObject, $parameters);
        
        // 結果検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 文字列が渡された場合はfalseを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', 'test string', $parameters);
        
        // 結果検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function 整数が渡された場合はfalseを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', 123, $parameters);
        
        // 結果検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function nullが渡された場合はfalseを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', null, $parameters);
        
        // 結果検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function booleanが渡された場合はfalseを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // テスト実行
        $actual = $instance->passes('test_attribute', true, $parameters);
        
        // 結果検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function 通常のオブジェクトが渡された場合はfalseを返す(): void
    {
        // テスト対象のインスタンス作成
        $instance = new CountableRule();
        
        // モックパラメータ作成
        $parameters = $this->createParameter([]);
        
        // 通常のオブジェクト作成
        $object = new \stdClass();
        
        // テスト実行
        $actual = $instance->passes('test_attribute', $object, $parameters);
        
        // 結果検証
        $this->assertFalse($actual);
    }
}