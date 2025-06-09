<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\StringRule;

/**
 * StringRuleクラスのユニットテスト
 */
class StringRuleTest extends TestCase
{
    #[Test]
    public function 文字列値を渡すとtrueを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = 'テスト文字列';
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        $expected = true;
        
        // 文字列値の場合はtrueが返されることを確認
        $this->assertTrue($actual);
    }

    #[Test]
    public function 空文字列を渡すとtrueを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = '';
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // 空文字列の場合はfalseが返されることを確認
        $this->assertTrue($actual);
    }

    #[Test]
    public function null値を渡すとfalseを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = null;
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // null値の場合はfalseが返されることを確認
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値を渡すとtrueを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = 123;
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // 数値の場合はfalseが返されることを確認
        $this->assertTrue($actual);
    }

    #[Test]
    public function 配列を渡すとfalseを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = ['test', 'array'];
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // 配列の場合はfalseが返されることを確認
        $this->assertFalse($actual);
    }

    #[Test]
    public function オブジェクトを渡すとfalseを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = new \stdClass();
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // オブジェクトの場合はfalseが返されることを確認
        $this->assertFalse($actual);
    }

    #[Test]
    public function boolean値trueを渡すとfalseを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = true;
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // boolean値の場合はfalseが返されることを確認
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値文字列を渡すとtrueを返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new StringRule();
        
        // テスト用のパラメータを準備
        $attribute = 'test_field';
        $value = '123';
        $parameters = $this->createParameter([]);
        $arguments = [];
        
        // テストを実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);
        
        // 数値文字列の場合はtrueが返されることを確認
        $this->assertTrue($actual);
    }
}