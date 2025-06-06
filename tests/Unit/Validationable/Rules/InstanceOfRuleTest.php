<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\InstanceOfRule;

class InstanceOfRuleTest extends TestCase
{
    #[Test]
    public function 引数が空の場合は例外をスローする(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);

        // 例外がスローされることを期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("InstanceOf rule requires arguments.");

        // テスト実行
        $instance->passes('test_attribute', 'test_value', $parameters, []);
    }

    #[Test]
    public function 値がクラスのインスタンスの場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = new \DateTime();

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTime']);

        // 検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 値がクラスのインスタンスでない場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = 'string_value';

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTime']);

        // 検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function サブクラスフラグがtrueで値がサブクラスの場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = new \DateTime();

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTimeInterface', true]);

        // 検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function サブクラスフラグがtrueで値がサブクラスでない場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = new \stdClass();

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTime', true]);

        // 検証
        $this->assertFalse($actual);
    }

    #[Test]
    public function サブクラスフラグがfalseで値が直接のインスタンスの場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = new \DateTime();

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTime', false]);

        // 検証
        $this->assertTrue($actual);
    }

    #[Test]
    public function 第二引数が省略された場合はデフォルトでfalseとして扱われる(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new InstanceOfRule();
        $parameters = $this->createParameter([]);
        $value = new \DateTime();

        // テスト実行
        $actual = $instance->passes('test_attribute', $value, $parameters, ['DateTime']);

        // 検証
        $this->assertTrue($actual);
    }
}