<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HostnameRule;

class HostnameRuleTest extends TestCase
{
    #[Test]
    public function 有効なホスト名の場合はtrueを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertTrue($rule->passes('hostname', 'example.com', $this->createParameter([])));
    }

    #[Test]
    public function サブドメインを持つ有効なホスト名の場合はtrueを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertTrue($rule->passes('hostname', 'sub.domain.example.com', $this->createParameter([])));
    }

    #[Test]
    public function ハイフンを含む有効なホスト名の場合はtrueを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertTrue($rule->passes('hostname', 'example-domain.com', $this->createParameter([])));
    }

    #[Test]
    public function 数字を含む有効なホスト名の場合はtrueを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertTrue($rule->passes('hostname', 'example123.com', $this->createParameter([])));
    }

    #[Test]
    public function localhostの場合はtrueを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertTrue($rule->passes('hostname', 'localhost', $this->createParameter([])));
    }

    #[Test]
    public function 先頭がハイフンの場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertFalse($rule->passes('hostname', '-example.com', $this->createParameter([])));
    }

    #[Test]
    public function 末尾がハイフンの場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertFalse($rule->passes('hostname', 'example.com-', $this->createParameter([])));
    }

    #[Test]
    public function アンダースコアが含まれる場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertFalse($rule->passes('hostname', 'example_domain.com', $this->createParameter([])));
    }

    #[Test]
    public function 長すぎるホスト名の場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $longHostname = str_repeat('a', 256);
        $this->assertFalse($rule->passes('hostname', $longHostname, $this->createParameter([])));
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertFalse($rule->passes('hostname', null, $this->createParameter([])));
    }

    #[Test]
    public function 空文字列の場合はfalseを返す(): void
    {
        $rule = new HostnameRule();
        $this->assertFalse($rule->passes('hostname', '', $this->createParameter([])));
    }
}
