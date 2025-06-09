<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\Str;
use Validationable\Rules\ClosureRule;

class ClosureRuleTest extends TestCase
{
    #[Test]
    public function 値がクロージャの場合はtrueを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', function () {
        }, $parameters);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 値がCallableな関数の場合はtrueを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', 'strlen', $parameters);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 値がinvokeメソッドを持つオブジェクトの場合はtrueを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $invokableObject = new class {
            public function __invoke()
            {
            }
        };

        $actual = $instance->passes('test_attribute', $invokableObject, $parameters);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 値が文字列の場合はfalseを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', 'not_callable_string', $parameters);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が数値の場合はfalseを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', 123, $parameters);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が配列の場合はfalseを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', [], $parameters);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 値がinvokeメソッドを持たない通常のオブジェクトの場合はfalseを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $normalObject = new \stdClass();

        $actual = $instance->passes('test_attribute', $normalObject, $parameters);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 値がnullの場合はfalseを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', null, $parameters);

        $this->assertFalse($actual);
    }

    #[Test]
    public function 配列形式のCallableの場合はtrueを返す(): void
    {
        $instance = new ClosureRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', [Str::class, 'of'], $parameters);

        $this->assertTrue($actual);
    }
}