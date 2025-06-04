<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\RequiredIfRule;

class RequiredIfRuleTest extends TestCase
{
    #[Test]
    public function 引数が空の時に例外が発生する(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter(['test' => 'value']);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("RequiredIf rule requires arguments.");

        $instance->passes('test', $params, []);
    }

    #[Test]
    public function 条件フィールドが存在しない場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params =  $this->createParameter([]);
        $actual = $instance->passes('test', $params, ['test2']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドがnullの場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter(['condition_field' => null]);
        $actual = $instance->passes('target_field', $params, ['condition_field']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドが空文字の場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter(['condition_field' => '']);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドが存在し対象フィールドも存在する場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => 'target_value'
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 複数の条件フィールドが存在し対象フィールドも存在する場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field1' => 'some_value',
            'condition_field2' => 'some_value',
            'target_field' => 'target_value'
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field1', 'condition_field2']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 複数の条件フィールドが存在・存在せず対象フィールドも存在しない場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field1' => 'some_value',
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field1', 'condition_field2']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドが存在するが対象フィールドが存在しない場合にFalseが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value'
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 条件フィールドが存在するが対象フィールドがnullの場合にFalseが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => null
        ]);
        $actual = $instance->passes('target_field', $params, ['condition_field']);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 条件フィールドが存在するが対象フィールドが空文字の場合にFalseが返る(): void
    {
        $instance = new RequiredIfRule();
        $params =  $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => ''
        ]);
        $actual = $instance->passes('target_field',$params, ['condition_field']);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 条件フィールドが存在するが対象フィールドが空配列の場合にFalseが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => []
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 条件フィールドが存在し対象フィールドが数値のゼロの場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => 0
        ]);
        $actual = $instance->passes('target_field',$params , ['condition_field']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドが存在し対象フィールドが文字列のゼロの場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => '0'
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 条件フィールドが存在し対象フィールドがfalseの場合にTrueが返る(): void
    {
        $instance = new RequiredIfRule();
        $params = $this->createParameter([
            'condition_field' => 'some_value',
            'target_field' => false
        ]);
        $actual = $instance->passes('target_field', $params , ['condition_field']);

        $this->assertTrue($actual);
    }
}