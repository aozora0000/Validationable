<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\LengthRule;

class LengthRuleTest extends TestCase
{
    #[Test]
    public function 引数が空の場合はfalseを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('test', 'value', $parameters, []);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 引数に整数以外が含まれる場合は例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Length rule requires integer arguments.");
        
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        
        $instance->passes('test', 'value', $parameters, ['not_integer']);
    }

    #[Test]
    public function 値が文字列の場合は文字列長と比較を返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('test', 'string', $parameters, ['6']);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が1つで配列の長さが一致する場合はtrueを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3]; // 長さ3の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['3']);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が1つで配列の長さが一致しない場合はfalseを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3]; // 長さ3の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['5']);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 引数が複数で配列の長さが範囲内の場合はtrueを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3]; // 長さ3の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['2', '5']);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が複数で配列の長さが最小値未満の場合はfalseを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1]; // 長さ1の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['2', '5']);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 引数が複数で配列の長さが最大値超過の場合はfalseを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3, 4, 5, 6]; // 長さ6の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['2', '5']);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 引数が複数で配列の長さが最小値と同じ場合はtrueを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2]; // 長さ2の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['2', '5']);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が複数で配列の長さが最大値と同じ場合はtrueを返す(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3, 4, 5]; // 長さ5の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['2', '5']);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数の順序が逆でも正しく動作する(): void
    {
        $instance = new LengthRule();
        $parameters = $this->createParameter([]);
        $value = [1, 2, 3]; // 長さ3の配列
        
        $actual = $instance->passes('test', $value, $parameters, ['5', '2']); // 順序が逆
        
        $this->assertTrue($actual);
    }
}