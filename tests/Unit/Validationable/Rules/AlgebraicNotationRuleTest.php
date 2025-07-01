<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\AlgebraicNotationRule;

class AlgebraicNotationRuleTest extends TestCase
{
    #[Test]
    public function aN形式で値が倍数の場合にtrueを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 12]);
        $this->assertTrue($instance->passes('field', 12, $parameters, ['6N']), '12は6の倍数です');
    }

    #[Test]
    public function aN形式で値が倍数でない場合にfalseを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 13]);
        $this->assertFalse($instance->passes('field', 13, $parameters, ['6N']), '13は6の倍数ではありません');
    }

    #[Test]
    public function aN_plus_b形式で条件を満たす場合にtrueを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 7]);
        $this->assertTrue($instance->passes('field', 7, $parameters, ['2n+1']), '7は2n+1の形式です (n=3)');
    }

    #[Test]
    public function aN_plus_b形式で条件を満たさない場合にfalseを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 8]);
        $this->assertFalse($instance->passes('field', 8, $parameters, ['2n+1']), '8は2n+1の形式ではありません');
    }

    #[Test]
    public function aN_minus_b形式で条件を満たす場合にtrueを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 5]);
        $this->assertTrue($instance->passes('field', 5, $parameters, ['3N-1']), '5は3N-1の形式です (n=2)');
    }

    #[Test]
    public function aN_minus_b形式で条件を満たさない場合にfalseを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 6]);
        $this->assertFalse($instance->passes('field', 6, $parameters, ['3N-1']), '6は3N-1の形式ではありません');
    }

    #[Test]
    public function 値が数値でない場合にfalseを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 'not-a-number']);
        $this->assertFalse($instance->passes('field', 'not-a-number', $parameters, ['2n+1']));
    }

    #[Test]
    public function 引数が空の場合に例外を投げる(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 10]);
        $this->expectException(\InvalidArgumentException::class);
        $instance->passes('field', 10, $parameters, []);
    }

    #[Test]
    public function 不正なフォーマットの場合に例外を投げる(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 10]);
        $this->expectException(\InvalidArgumentException::class);
        $instance->passes('field', 10, $parameters, ['N6']);
    }

    #[Test]
    public function 係数が0の場合にfalseを返す(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 10]);
        $this->assertFalse($instance->passes('field', 10, $parameters, ['0N+5']));
    }

    #[Test]
    public function スペースが含まれていても正しく動作する(): void
    {
        $instance = new AlgebraicNotationRule();
        $parameters = $this->createParameter(['field' => 7]);
        $this->assertTrue($instance->passes('field', 7, $parameters, ['2n + 1']), 'スペースが含まれていても解釈できるべきです');
    }
}
