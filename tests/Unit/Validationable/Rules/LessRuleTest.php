<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\LessThanRule;

/**
 * LessRuleクラスのユニットテスト
 */
class LessRuleTest extends TestCase
{
    #[Test]
    public function 引数が空の場合例外が発生する(): void
    {
        $instance = new LessThanRule();
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Less rule requires parameters.");
        $params = $this->createParameter([]);
        $instance->passes('test', '5', $params, []);
    }

    #[Test]
    public function 引数が整数でない場合例外が発生する(): void
    {
        $instance = new LessThanRule();
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Less rule requires integer arguments.");
        $params = $this->createParameter([]);
        $instance->passes('test', '5', $params, ['abc']);
    }

    #[Test]
    public function 値が文字列の場合偽を返す(): void
    {
        $instance = new LessThanRule();
        

        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 'abc', $params, [10]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が実数の場合真を返す(): void
    {
        $instance = new LessThanRule();


        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 5.5, $params, [10]);

        $this->assertTrue($actual);
    }

    #[Test]
    public function 値が引数より小さい場合真を返す(): void
    {
        $instance = new LessThanRule();
        

        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 5, $params, [10]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 値が引数と等しい場合偽を返す(): void
    {
        $instance = new LessThanRule();
        
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 10, $params, [10]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が引数より大きい場合偽を返す(): void
    {
        $instance = new LessThanRule();
        
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 15, $params, [10]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 負の値が正の引数より小さい場合真を返す(): void
    {
        $instance = new LessThanRule();
        
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', -5, $params, [0]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 複数の引数がある場合最初の引数と比較する(): void
    {
        $instance = new LessThanRule();
        
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', 5, $params, [10, 20, 30]);
        
        $this->assertTrue($actual);
    }
}