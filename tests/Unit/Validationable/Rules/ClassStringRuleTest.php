<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ClassStringRule;

class ClassStringRuleTest extends TestCase
{
    public static function 非文字列値のデータプロバイダー(): array
    {
        return [
            '整数' => [123],
            'float' => [12.34],
            'null' => [null],
            '配列' => [['test']],
            'オブジェクト' => [new \stdClass()],
            'bool真' => [true],
            'bool偽' => [false],
        ];
    }

    public static function 存在しないクラス名のデータプロバイダー(): array
    {
        return [
            '存在しないクラス' => ['NonExistentClass'],
            '空文字' => [''],
            '不正なクラス名' => ['Invalid\\Class\\Name\\That\\Does\\Not\\Exist'],
        ];
    }

    public static function 存在するクラス名のデータプロバイダー(): array
    {
        return [
            'DateTime' => ['DateTime'],
            'stdClass' => ['stdClass'],
            'Exception' => ['Exception'],
            'PDO' => ['PDO'],
        ];
    }

    public static function サブクラス関係のデータプロバイダー(): array
    {
        return [
            'ExceptionはThrowableのサブクラス' => ['Exception', 'Throwable'],
            'RuntimeExceptionはExceptionのサブクラス' => ['RuntimeException', 'Exception'],
            'InvalidArgumentExceptionはRuntimeExceptionのサブクラス' => ['InvalidArgumentException', 'LogicException'],
        ];
    }

    public static function サブクラス関係でないデータプロバイダー(): array
    {
        return [
            'stdClassはExceptionのサブクラスでない' => ['stdClass', 'Exception'],
            'DateTimeはThrowableのサブクラスでない' => ['DateTime', 'Throwable'],
            'PDOはDateTimeのサブクラスでない' => ['PDO', 'DateTime'],
        ];
    }

    public static function 引数が非文字列のデータプロバイダー(): array
    {
        return [
            'null' => [null],
            '配列' => [['test']],
            'オブジェクト' => [new \stdClass()],
            'bool' => [true],
        ];
    }

    #[Test]
    #[DataProvider('非文字列値のデータプロバイダー')]
    public function 文字列でない値の場合はfalseを返す(mixed $value): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', $value, $this->createParameter([]), []);

        $this->assertFalse($actual);
    }

    #[Test]
    #[DataProvider('存在しないクラス名のデータプロバイダー')]
    public function 存在しないクラス名の場合はfalseを返す(string $className): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', $className, $this->createParameter([]), []);

        $this->assertFalse($actual);
    }

    #[Test]
    #[DataProvider('存在するクラス名のデータプロバイダー')]
    public function 存在するクラス名の場合はtrueを返す(string $className): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', $className, $this->createParameter([]), []);

        $this->assertTrue($actual);
    }

    #[Test]
    #[DataProvider('サブクラス関係のデータプロバイダー')]
    public function サブクラス関係をチェックしてtrueを返す(string $childClass, string $parentClass): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', $childClass, $this->createParameter([]), [$parentClass]);

        $this->assertTrue($actual);
    }

    #[Test]
    #[DataProvider('サブクラス関係でないデータプロバイダー')]
    public function サブクラス関係でない場合はfalseを返す(string $className, string $parentClass): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', $className, $this->createParameter([]), [$parentClass]);

        $this->assertFalse($actual);
    }

    #[Test]
    #[DataProvider('引数が非文字列のデータプロバイダー')]
    public function 引数の第一要素が文字列でない場合はtrueを返す(mixed $argument): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', 'stdClass', $this->createParameter([]), [$argument]);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が空の場合は存在するクラスならtrueを返す(): void
    {
        $instance = new ClassStringRule();
        $actual = $instance->passes('attribute', 'stdClass', $this->createParameter([]), []);

        $this->assertTrue($actual);
    }
}