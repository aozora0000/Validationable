<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\Ipv4Rule;

class Ipv4RuleTest extends TestCase
{
    /**
     * テスト：有効なIPv4アドレスを検証
     */
    #[Test]
    public function 有効なIPv4アドレスを検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', '192.168.1.1', $params);
        $this->assertTrue($actual, '有効なIPv4アドレスが検出されるべきです。');
    }

    /**
     * テスト：無効なIPv4アドレスを検証
     */
    #[Test]
    public function 無効なIPv4アドレスを検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', '999.999.999.999', $params);
        $this->assertFalse($actual, '無効なIPv4アドレスが拒否されるべきです。');
    }

    /**
     * テスト：IPv4形式ではない文字列の場合
     */
    #[Test]
    public function IPv4形式ではない文字列を検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', 'not-an-ip', $params);
        $this->assertFalse($actual, 'IPv4形式ではない文字列は拒否されるべきです。');
    }

    /**
     * テスト：空文字の場合
     */
    #[Test]
    public function 空文字を検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', '', $params);
        $this->assertFalse($actual, '空文字は拒否されるべきです。');
    }

    /**
     * テスト：null値の場合
     */
    #[Test]
    public function null値を検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', null, $params);
        $this->assertFalse($actual, 'null値は拒否されるべきです。');
    }

    /**
     * テスト：IPv6アドレスの場合
     */
    #[Test]
    public function IPv6アドレスを検証する()
    {
        $instance = new Ipv4Rule();
        $params = $this->createParameter([]);

        $actual = $instance->passes('ip', '2001:0db8:85a3:0000:0000:8a2e:0370:7334', $params);
        $this->assertFalse($actual, 'IPv6アドレスはIPv4検証では拒否されるべきです。');
    }
}