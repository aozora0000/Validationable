<?php

namespace Test\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ConstructableRule;

class ConstructableRuleTest extends TestCase
{
    /**
     * ObjectCreatableRule::passes()メソッドは引数が存在しない場合、例外をスローすることを確認します。
     */
    #[Test]
    public function 引数が存在しない場合例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("ConstructableRule rule requires at least one argument");
        $params = $this->createParameter([]);
        $instance = new ConstructableRule();
        $instance->passes('attribute', ['key' => 'value'], $params);
    }

    /**
     * ObjectCreatableRule::passes()メソッドは引数が正しいクラス名でない場合、例外をスローすることを確認します。
     */
    #[Test]
    public function 正しくないクラス名の場合例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("ConstructableRule rule requires a valid class name");
        $params = $this->createParameter([]);
        $instance = new ConstructableRule();
        $instance->passes('attribute', ['key' => 'value'], $params, ['InvalidClassName']);
    }

    /**
     * ObjectCreatableRule::passes()メソッドは渡された値が配列でない場合、falseを返すことを確認します。
     */
    #[Test]
    public function 値が配列でない場合falseを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'notAnArray', $params, [\stdClass::class]);
        $this->assertFalse($actual, '値が配列でない場合、falseが返されるべきです。');
    }

    /**
     * ObjectCreatableRule::passes()メソッドはクラスがコンストラクタを持たない場合、falseを返すことを確認します。
     */
    #[Test]
    public function クラスがコンストラクタを持たない場合falseを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', [], $params, [\stdClass::class]);
        $this->assertFalse($actual, 'コンストラクタがないクラスを渡した場合、falseが返されるべきです。');
    }

    /**
     * ObjectCreatableRule::passes()メソッドは渡された値がコンストラクタのパラメータと異なる場合、falseを返すことを確認します。
     */
    #[Test]
    public function 渡された値がコンストラクタのパラメータと異なる場合falseを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', ['key' => 'value'], $params, [ClassWithConstructor::class]);
        $this->assertFalse($actual, '渡された値がコンストラクタのパラメータと異なる場合、falseが返されるべきです。');
    }

    /**
     * ObjectCreatableRule::passes()メソッドがすべての要件を満たしている場合、trueを返すことを確認します。
     */
    #[Test]
    public function 必須要件を満たしている場合trueを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', ['param1' => 'value1'], $params, [ClassWithConstructor::class]);
        $this->assertTrue($actual, 'すべての要件を満たしている場合、trueが返されるべきです。');
    }

    /**
     * ObjectCreatableRule::passes()メソッドがすべての要件を満たしている場合、trueを返すことを確認します。
     */
    #[Test]
    public function 全ての要件を満たしている場合trueを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', ['param1' => 'value1', 'param2' => 'value2', 'param3' => 'value3'], $params, [ClassWithConstructor::class]);
        $this->assertTrue($actual, 'すべての要件を満たしている場合、trueが返されるべきです。');
    }

    /**
     * ObjectCreatableRule::passes()メソッドがすべての要件を満たしている場合、trueを返すことを確認します。
     */
    #[Test]
    public function 引数名の要件を満たしているが型が違う場合falseを返す(): void
    {
        $instance = new ConstructableRule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('attribute', ['param1' => []], $params, [ClassWithConstructor::class]);
        $this->assertFalse($actual, '引数名の要件を満たしているが型が違う場合falseを返すべきです。');
    }
}

class ClassWithConstructor
{
    public function __construct(protected string $param1, protected string $param2 = 'default', protected ?string $param3 = null)
    {
    }
}