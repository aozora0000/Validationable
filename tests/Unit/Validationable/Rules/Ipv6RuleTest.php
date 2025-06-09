<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\Ipv6Rule;

class Ipv6RuleTest extends TestCase
{
    #[Test]
    public function パスするための有効なIpv6を確認する()
    {
        $instance = new Ipv6Rule();
        $value = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test', $value, $parameters);

        $this->assertTrue($actual, '有効なIPv6アドレスがパスしませんでした。');
    }

    #[Test]
    public function 無効なIpv6を検証する()
    {
        $instance = new Ipv6Rule();
        $value = 'invalid-ipv6';
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test', $value, $parameters);

        $this->assertFalse($actual, '無効なIPv6アドレスがパスしました。');
    }

    #[Test]
    public function 空の値がIpv6として失敗するかを確認する()
    {
        $instance = new Ipv6Rule();
        $value = '';
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test', $value, $parameters);

        $this->assertFalse($actual, '空の値がIPv6としてパスしました。');
    }

    #[Test]
    public function Ipv4変換可能なIpv6がパスするか確認する()
    {
        $instance = new Ipv6Rule();
        $value = '::ffff:192.0.2.128';
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test', $value, $parameters);

        $this->assertTrue($actual, 'IPv4マッピングされたIPv6アドレスがパスしませんでした。');
    }

    #[Test]
    public function 数値値がIpv6として失敗するか確認する()
    {
        $instance = new Ipv6Rule();
        $value = 123456;
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test', $value, $parameters);

        $this->assertFalse($actual, '数値値がIPv6としてパスしました。');
    }
}