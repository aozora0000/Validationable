<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\MissingRule;

class MissingRuleTest extends TestCase
{
    /**
     * MissingRuleのpassesメソッドが、
     * 属性が存在する場合にtrueを返すかテストします。
     */
    #[Test]
    public function 属性が存在する場合にtrueを返す()
    {
        $parameters = $this->createParameter(['key' => null]);

        $instance = new MissingRule();
        $attribute = 'key';
        $value = null;
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '属性が存在する場合にtrueを返す処理が正しくありません。');
    }

    /**
     * MissingRuleのpassesメソッドが、
     * 属性が存在しない場合にfalseを返すかテストします。
     */
    #[Test]
    public function 属性が存在しない場合にfalseを返す()
    {
        $parameters = $this->createParameter([]);

        $instance = new MissingRule();
        $attribute = 'missing_key';
        $value = null;
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '属性が存在しない場合にfalseを返す処理が正しくありません。');
    }
}