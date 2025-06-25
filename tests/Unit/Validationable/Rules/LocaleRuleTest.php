<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\LocaleRule;

class LocaleRuleTest extends TestCase
{
    /**
     * 有効なロケールの場合にテストが成功することを確認します。
     */
    #[Test]
    public function 有効なロケールを検証する(): void
    {
        $instance = new LocaleRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('locale', 'en_US', $parameters);

        $this->assertTrue($actual, '有効なロケールが失敗と判定されています。');
    }

    /**
     * 無効なロケールの場合にテストが失敗することを確認します。
     */
    #[Test]
    public function 無効なロケールを検証する(): void
    {
        $instance = new LocaleRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('locale', 'invalid_locale', $parameters);

        $this->assertFalse($actual, '無効なロケールが成功と判定されています。');
    }

    /**
     * 空文字がロケールとして無効であることを確認します。
     */
    #[Test]
    public function 空文字のロケールを検証する(): void
    {
        $instance = new LocaleRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('locale', '', $parameters);

        $this->assertFalse($actual, '空文字が成功と判定されています。');
    }

    /**
     * NULLがロケールとして無効であることを確認します。
     */
    #[Test]
    public function NULLロケールを検証する(): void
    {
        $instance = new LocaleRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('locale', null, $parameters);

        $this->assertFalse($actual, 'NULLが成功と判定されています。');
    }

    /**
     * 数値がロケールとして無効であることを確認します。
     */
    #[Test]
    public function 数値のロケールを検証する(): void
    {
        $instance = new LocaleRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('locale', 12345, $parameters);

        $this->assertFalse($actual, '数値が成功と判定されています。');
    }
}