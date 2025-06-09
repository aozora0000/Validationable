<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
use Validationable\Rules\RegexPatternRule;

/**
 * RegexRuleのテストクラス
 */
class RegexRuleTest extends TestCase
{
    #[Test]
    public function 有効な正規表現パターンでtrueを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', '/^[a-z]+$/', $parameters);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 無効な正規表現パターンでfalseを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', '[a-z+', $parameters);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 空文字列でfalseを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', '', $parameters);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function null値でfalseを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', null, $parameters);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値でfalseを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', 123, $parameters);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 配列でfalseを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', ['pattern'], $parameters);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 複雑な正規表現パターンでtrueを返す(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        
        $actual = $instance->passes('field', '/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/', $parameters);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数付きでも正常に動作する(): void
    {
        $instance = new RegexPatternRule();
        $parameters = $this->createParameter([]);
        $arguments = ['some', 'arguments'];
        
        $actual = $instance->passes('field', '/\d+/', $parameters, $arguments);
        
        $this->assertTrue($actual);
    }
}