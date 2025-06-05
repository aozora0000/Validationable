<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\IntegerRule;

class IntegerRuleTest extends TestCase
{
    #[Test]
    public function 整数の時にTrueが返る(): void
    {
        $rule = new IntegerRule();
        $actual = $rule->passes('test', '1000', $this->createParameter(['test' => '1000']));
        $this->assertTrue($actual);
    }


    #[Test]
    public function 負の整数の時にTrueが返る(): void
    {
        $rule = new IntegerRule();
        $actual = $rule->passes('test', '-1000', $this->createParameter(['test' => '-1000']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 存在しないデータの時にFalseが返る(): void
    {
        $rule = new IntegerRule();
        $actual = $rule->passes('invalidKey',null, $this->createParameter(['test' => 'test']));
        $this->assertFalse($actual);
    }

    #[Test]
    #[DataProvider('notIntegerProvider')]
    public function 整数でないデータの時にFalseが返る(mixed $value, string $message): void
    {
        $rule = new IntegerRule();
        $actual = $rule->passes('test', $value, $this->createParameter(['test' => $value]));
        $this->assertFalse($actual, $message);
    }

    public static function notIntegerProvider(): array
    {
        return [
            ['a', '整数でない'],
            ['1000a', '整数が入る文字列'],
            ['10.0', '実数'],
            [['1'], '配列']
        ];
    }
}