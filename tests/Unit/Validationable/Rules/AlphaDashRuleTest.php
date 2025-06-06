<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\AlphaDashRule;

class AlphaDashRuleTest extends TestCase
{
    #[Test]
    public function アルファベット文字列の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'abc', $params, []);
        
        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function アルファベット文字列とダッシュ記号の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();

        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', '_abc-', $params, []);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 大文字のアルファベット文字列の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'ABC', $params, []);
        
        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 大文字と小文字が混在したアルファベット文字列の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'AbC', $params, []);
        
        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 数字が含まれた文字列の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'abc123', $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 記号が含まれた文字列の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'abc!', $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function スペースが含まれた文字列の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 'a bc', $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 空文字列の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', '', $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', null, $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function boolの場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();

        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', true, $params, []);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値型の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new AlphaDashRule();
        
        // テスト実行
        $params = $this->createParameter([]);
        $actual = $instance->passes('test_attribute', 123, $params, []);
        
        // アサーション
        $this->assertFalse($actual);
    }
}