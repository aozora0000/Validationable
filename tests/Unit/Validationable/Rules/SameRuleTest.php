<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
use Validationable\Rules\SameRule;

class SameRuleTest extends TestCase
{
    #[Test]
    public function 値が同じ場合に正しい結果を返す()
    {
        // テスト対象のインスタンス
        $instance = new SameRule();

        // 比較対象
        $expected = ['key' => 'value'];

        // Parametersインスタンスを作成
        $parameters = $this->createParameter($expected);

        // 実際の結果
        $actual = $instance->passes('key', 'value', $parameters);

        // アサーション
        $this->assertTrue($actual, '値が一致する場合、trueを返す必要があります');
    }

    #[Test]
    public function 値が異なる場合に正しい結果を返す()
    {
        // テスト対象のインスタンス
        $instance = new SameRule();

        // 比較対象
        $expected = ['key' => 'value'];

        // Parametersインスタンスを作成
        $parameters = $this->createParameter($expected);

        // 実際の結果
        $actual = $instance->passes('key', 'differentValue', $parameters);

        // アサーション
        $this->assertFalse($actual, '値が一致しない場合、falseを返す必要があります');
    }

    #[Test]
    public function 属性が存在しない場合に正しい結果を返す()
    {
        // テスト対象のインスタンス
        $instance = new SameRule();

        // 比較対象
        $expected = ['differentKey' => 'value'];

        // Parametersインスタンスを作成
        $parameters = $this->createParameter($expected);

        // 実際の結果
        $actual = $instance->passes('key', 'value', $parameters);

        // アサーション
        $this->assertFalse($actual, '属性が存在しない場合、falseを返す必要があります');
    }
}