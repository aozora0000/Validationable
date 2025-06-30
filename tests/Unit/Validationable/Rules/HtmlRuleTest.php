<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HtmlRule;

class HtmlRuleTest extends TestCase
{
    /**
     * HtmlRule::passes() メソッドが正しいHTML文字列を検証できるか確認します。
     */
    #[Test]
    public function 正しいHTML文字列が許可される(): void
    {
        $instance = new HtmlRule();
        $parameters = $this->createParameter([]);
        $attribute = 'content';
        $value = '<div><p>Hello World</p></div>';
        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertTrue($actual, '正しいHTML文字列が許可されませんでした。');
    }

    /**
     * HtmlRule::passes() メソッドが空文字列を拒否するか確認します。
     */
    #[Test]
    public function 空文字列が拒否される(): void
    {
        $instance = new HtmlRule();
        $parameters = $this->createParameter([]);
        $attribute = 'content';
        $value = '';
        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, '空文字列が拒否されませんでした。');
    }

    /**
     * HtmlRule::passes() メソッドがnullを拒否するか確認します。
     */
    #[Test]
    public function nullが拒否される(): void
    {
        $instance = new HtmlRule();
        $parameters = $this->createParameter([]);
        $attribute = 'content';
        $value = null;
        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, 'nullが拒否されませんでした。');
    }

    /**
     * HtmlRule::passes() メソッドが無効な型（配列など）を拒否するか確認します。
     */
    #[Test]
    public function 無効な型が拒否される(): void
    {
        $instance = new HtmlRule();
        $parameters = $this->createParameter([]);
        $attribute = 'content';
        $value = ['<div><p>Hello World</p></div>'];
        $actual = $instance->passes($attribute, $value, $parameters);

        $this->assertFalse($actual, '無効な型（配列）が拒否されませんでした。');
    }
}