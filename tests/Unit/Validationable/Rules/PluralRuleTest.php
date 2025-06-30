<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\PluralRule;

class PluralRuleTest extends TestCase
{
    /**
     * プリミティブ型の値が渡された場合、必ずfalseを返す
     */
    #[Test]
    public function プリミティブ型値を渡すと失敗する(): void
    {
        $instance = new PluralRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 123, $parameters);
        $this->assertFalse($actual, '数値型の入力が渡されたとき、passesメソッドがtrueを返してはいけません。');
    }

    /**
     * 文字列が単数形の場合、falseを返す
     */
    #[Test]
    public function 単数形文字列を渡すと失敗する(): void
    {
        $instance = new PluralRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'apple', $parameters, ['english']);
        $this->assertFalse($actual, '単数形の文字列が渡されたとき、passesメソッドがtrueを返してはいけません。');
    }

    /**
     * 文字列が複数形の場合、trueを返す
     */
    #[Test]
    public function 複数形文字列を渡すと成功する(): void
    {
        $instance = new PluralRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'apples', $parameters, ['english']);
        $this->assertTrue($actual, '複数形の文字列が渡されたとき、passesメソッドがfalseを返してはいけません。');
    }

    /**
     * 無効な言語コードが渡された場合、例外がスローされる
     */
    #[Test]
    public function 無効な言語コードを渡すと例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid language');

        $instance = new PluralRule();
        $parameters = $this->createParameter([]);

        $instance->passes('attribute', 'apples', $parameters, ['invalid-language']);
    }

    /**
     * 引数を渡さない場合デフォルトが適用される
     */
    #[Test]
    public function 引数を渡さないとデフォルト英語になる(): void
    {
        $instance = new PluralRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'apples', $parameters);
        $this->assertTrue($actual, '言語コードを渡さない場合、デフォルトの英語設定が動作しませんでした。');
    }
}