<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\IataRule;

class IataRuleTest extends TestCase
{
    #[Test]
    public function 値が正しいIATAである場合にtrueが返却される(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new IataRule();
        $parameters = $this->createParameter([]);

        // KIXは関西国際空港のIATAコード（RJBBのIATA）
        $value = 'KIX';
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertTrue($actual, '正しいIATAコードの場合にtrueが返されます。');
    }

    #[Test]
    public function 値が不正なIATAである場合にfalseが返却される(): void
    {
        $instance = new IataRule();
        $parameters = $this->createParameter([]);

        // 存在しないIATAコード
        $value = 'ZZZ';
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertFalse($actual, '不正なIATAコードの場合にfalseが返されます。');
    }

    #[Test]
    public function 値が文字列ではない場合にfalseが返却される(): void
    {
        $instance = new IataRule();
        $parameters = $this->createParameter([]);

        // 数値（文字列ではない）
        $value = 12345;
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertFalse($actual, '値が文字列ではない場合にfalseが返されます。');
    }
}
