<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\DomainRule;

class DomainRuleTest extends TestCase
{
    #[Test]
    public function ドメインが有効な場合はtrueを返す()
    {
        $instance = new DomainRule();
        $parameters = $this->createParameter([]);
        $value = 'example.com';
        $attribute = 'domain';

        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertTrue($actual, '有効なドメインが失敗と判定されました。');
    }

    // 値が空文字の場合、`passes` メソッドが false を返すかテストする
    #[Test]
    public function 値が空文字の場合はfalseを返す()
    {
        $instance = new DomainRule();
        $parameters = $this->createParameter([]);
        $value = '';
        $attribute = 'domain';

        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, '空の値が有効と判定されました。');
    }

    // 値が無効なドメインの場合に `passes` メソッドが false を返すかテストする
    #[Test]
    public function 値が無効なドメインの場合はfalseを返す()
    {
        $instance = new DomainRule();
        $parameters = $this->createParameter([]);
        $value = 'invalid_domain';
        $attribute = 'domain';

        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, '無効なドメインが有効と判定されました。');
    }

    // ドメインの長さが25文字を超える場合に `passes` メソッドが false を返すかテストする
    #[Test]
    public function ドメインの長さが25文字を超える場合はfalseを返す()
    {
        $instance = new DomainRule();
        $parameters = $this->createParameter([]);
        $value = 'very-long-domain-name-example.com';
        $attribute = 'domain';

        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, '長すぎるドメインが有効と判定されました。');
    }
}