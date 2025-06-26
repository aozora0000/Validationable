<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\XmlRule;

class XmlRuleTest extends TestCase
{
    #[Test]
    public function 正常なXML文字列を渡すとtrueを返す(): void
    {
        // 準備
        $instance = new XmlRule();
        $value = '<root><key>value</key></root>';
        $params = $this->createParameter([]);

        // 実行
        $actual = $instance->passes('attribute', $value, $params);

        // 検証
        $this->assertTrue($actual, '正常なXML文字列が正しく判定されていません。');
    }

    #[Test]
    public function 空文字列を渡すとfalseを返す(): void
    {
        // 準備
        $instance = new XmlRule();
        $value = '';
        $params = $this->createParameter([]);

        // 実行
        $actual = $instance->passes('attribute', $value, $params);

        // 検証
        $this->assertFalse($actual, '空文字列がXMLとして誤って判定されています。');
    }

    #[Test]
    public function 不正なXML文字列を渡すとfalseを返す(): void
    {
        // 準備
        $instance = new XmlRule();
        $value = '<root><key>value</key>';
        $params = $this->createParameter([]);

        // 実行
        $actual = $instance->passes('attribute', $value, $params);

        // 検証
        $this->assertFalse($actual, '不正なXML文字列が正しく判定されていません。');
    }

    #[Test]
    public function nullを渡すとfalseを返す(): void
    {
        // 準備
        $instance = new XmlRule();
        $value = null;
        $params = $this->createParameter([]);

        // 実行
        $actual = $instance->passes('attribute', $value, $params);

        // 検証
        $this->assertFalse($actual, 'nullがXMLとして誤って判定されています。');
    }

    #[Test]
    public function 数値を渡すとfalseを返す(): void
    {
        // 準備
        $instance = new XmlRule();
        $value = 123;
        $params = $this->createParameter([]);

        // 実行
        $actual = $instance->passes('attribute', $value, $params);

        // 検証
        $this->assertFalse($actual, '数値がXMLとして誤って判定されています。');
    }
}
