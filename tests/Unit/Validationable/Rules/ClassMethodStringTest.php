<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ClassMethodString;

class ClassMethodStringTest extends TestCase
{
    #[Test]
    public function デフォルト区切り文字で存在するクラスメソッド文字列が有効な場合にtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('DateTime@format', 'DateTime@format', $parameters);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function カスタム区切り文字で存在するクラスメソッド文字列が有効な場合にtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('DateTime::format', 'DateTime::format', $parameters, ['::']);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 無効な値が渡された場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('test_attribute', 123, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 存在しないクラスメソッド文字列の場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('NonExistentClass@nonExistentMethod', 'NonExistentClass@nonExistentMethod', $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function null値が渡された場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('test_attribute', null, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 空文字列が渡された場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('test_attribute', '', $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 存在するクラスの存在しないメソッドの場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('DateTime@nonExistentMethod', 'DateTime@nonExistentMethod', $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 不正な形式の文字列の場合にfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ClassMethodString();

        // モックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('invalid_format', 'JustAPlainString', $parameters);

        // アサーション
        $this->assertFalse($actual);
    }
}