<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\IcaoRule;

class IcaoRuleTest extends TestCase
{
    #[Test]
    public function 値が正しいICAOである場合にtrueが返却される()
    {
        $instance = new IcaoRule();
        $parameters = $this->createParameter([]);


        $value = 'RJBB'; // 正しいICAOコード
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertTrue($actual, '正しいICAOコードの場合にtrueが返されます。');
    }

    #[Test]
    public function 値が不正なICAOである場合にfalseが返却される()
    {
        $instance = new IcaoRule();
        $parameters = $this->createParameter([]);


        $value = 'INVALID'; // 不正なICAOコード
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertFalse($actual, '不正なICAOコードの場合にfalseが返されます。');
    }

    #[Test]
    public function 値が文字列ではない場合にfalseが返却される()
    {
        $instance = new IcaoRule();
        $parameters = $this->createParameter([]);


        $value = 12345; // 数値（文字列ではない）
        $actual = $instance->passes('airport_code', $value, $parameters);

        $this->assertFalse($actual, '値が文字列ではない場合にfalseが返されます。');
    }
}