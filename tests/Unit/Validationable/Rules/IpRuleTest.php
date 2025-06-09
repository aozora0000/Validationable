<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\IpRule;

class IpRuleTest extends TestCase
{
    #[Test]
    public function IP_が有効なIPv4の場合_検証が成功する()
    {
        // テスト対象のクラス
        $instance = new IpRule();

        // テストデータ
        $attribute = 'ip';
        $value = '192.168.1.1';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertTrue($actual, '有効なIPv4アドレスである場合、検証は成功すべきです。');
    }

    #[Test]
    public function IP_が有効なIPv6の場合_検証が成功する()
    {
        $instance = new IpRule();
        $attribute = 'ip';
        $value = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '有効なIPv6アドレスである場合、検証は成功すべきです。');
    }

    #[Test]
    public function IP_が無効な文字列の場合_検証が失敗する()
    {
        $instance = new IpRule();
        $attribute = 'ip';
        $value = 'invalid-ip';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '無効なIPアドレスの場合、検証は失敗すべきです。');
    }

    #[Test]
    public function IP_が空文字の場合_検証が失敗する()
    {
        $instance = new IpRule();
        $attribute = 'ip';
        $value = '';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '空の文字列を検証する場合、検証は失敗すべきです。');
    }

    #[Test]
    public function IP_がnullの場合_検証が失敗する()
    {
        $instance = new IpRule();
        $attribute = 'ip';
        $value = null;
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '値がnullの場合、検証は失敗すべきです。');
    }

    #[Test]
    public function IP_が数値の場合_検証が失敗する()
    {
        $instance = new IpRule();
        $attribute = 'ip';
        $value = 12345;
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '値が単なる数値の場合、検証は失敗すべきです。');
    }
}