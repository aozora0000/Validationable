<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\LuhnRule;

class LuhnRuleTest extends TestCase
{
    #[Test]
    public function 有効なLuhn番号をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '79927398713', $params);
        $this->assertTrue($actual, '有効なLuhn番号が正しく検証できませんでした。');
    }

    #[Test]
    public function 無効なLuhn番号をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '79927398714', $params);
        $this->assertFalse($actual, '無効なLuhn番号が正しく否定されませんでした。');
    }

    #[Test]
    public function 数字以外を含む値をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '79927398A13', $params);
        $this->assertFalse($actual, '数字以外を含む値が正しく否定されませんでした。');
    }

    #[Test]
    public function 空の値をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '', $params);
        $this->assertFalse($actual, '空の値が正しく否定されませんでした。');
    }

    #[Test]
    public function 数値に変換できる形式の文字列をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '00000079927398713', $params);
        $this->assertTrue($actual, '有効なLuhn番号が前にゼロ付きの形式で正しく検証できませんでした。');
    }

    #[Test]
    public function null値をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', null, $params);
        $this->assertFalse($actual, 'null値が正しく否定されませんでした。');
    }

    #[Test]
    public function 数値型の値をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', 79927398713, $params);
        $this->assertFalse($actual, '数値型の値が正しく否定されませんでした。');
    }

    #[Test]
    public function 非標準的な長さのLuhn番号をテストする(): void
    {
        $instance = new LuhnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('credit_card', '42', $params);
        $this->assertTrue($actual, '短い有効なLuhn番号が正しく検証できませんでした。');
    }
}