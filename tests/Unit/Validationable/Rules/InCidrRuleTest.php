<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\InCidrRule;

class InCidrRuleTest extends TestCase
{
    /**
     * InCidrRule::passes メソッドが正常にCIDR範囲内のIPを判定するかテスト
     */
    #[Test]
    public function 正常なCIDR範囲内のIP(): void
    {
        $instance = new InCidrRule();
        $attribute = 'ip_address';
        $value = '192.168.1.1';
        $parameters = $this->createParameter([]);
        $arguments = ['192.168.1.0/24'];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, "正常なCIDR範囲内のIPが正しく判定されませんでした。");
    }

    /**
     * InCidrRule::passes メソッドがCIDR範囲外のIPを判定するかテスト
     */
    #[Test]
    public function CIDR範囲外のIP(): void
    {
        $instance = new InCidrRule();
        $attribute = 'ip_address';
        $value = '192.168.2.1';
        $parameters = $this->createParameter([]);
        $arguments = ['192.168.1.0/24'];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "CIDR範囲外のIPが正しく判定されませんでした。");
    }

    /**
     * InCidrRule::passes メソッドが無効なCIDRフォーマットを拒否するかテスト
     */
    #[Test]
    public function 無効なCIDRフォーマット(): void
    {
        $instance = new InCidrRule();
        $attribute = 'ip_address';
        $value = '192.168.1.1';
        $parameters = $this->createParameter([]);
        $arguments = ['192.168.1.0'];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "無効なCIDRフォーマットが正しく拒否されませんでした。");
    }

    /**
     * InCidrRule::passes メソッドが無効なIPアドレスを拒否するかテスト
     */
    #[Test]
    public function 無効なIPアドレス(): void
    {
        $instance = new InCidrRule();
        $attribute = 'ip_address';
        $value = '999.999.999.999';
        $parameters = $this->createParameter([]);
        $arguments = ['192.168.1.0/24'];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "無効なIPアドレスが正しく拒否されませんでした。");
    }

    /**
     * InCidrRule::passes メソッドが引数が空の場合に例外をスローするかテスト
     */
    #[Test]
    public function 空の引数で例外(): void
    {
        $instance = new InCidrRule();
        $attribute = 'ip_address';
        $value = '192.168.1.1';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("InCidr rule requires at least one argument");

        $instance->passes($attribute, $value, $parameters, $arguments);
    }
}