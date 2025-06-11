<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ArrayKeysRule;

class ArrayKeysRuleTest extends TestCase
{
    /**
     * `ArrayKeysRule::passes` メソッドは、配列のすべてのキーが指定された配列に存在する場合に true を返すべきです。
     */
    #[Test]
    public function 配列のキーが全て存在する場合にtrueを返す()
    {
        $instance = new ArrayKeysRule();
        $attribute = 'test';
        $value = ['a', 'b', 'c', 'd'];
        $parameters = $this->createParameter([]);
        $arguments = ['a', 'c'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'すべてのキーが配列に存在する場合に true が返される必要があります。');
    }

    /**
     * `ArrayKeysRule::passes` メソッドは、配列内の一部のキーが欠如している場合に false を返すべきです。
     */
    #[Test]
    public function 配列のキーが一部存在しない場合にfalseを返す()
    {
        $instance = new ArrayKeysRule();
        $attribute = 'test';
        $value = ['a', 'b', 'c', 'd'];
        $parameters = $this->createParameter([]);
        $arguments = ['a', 'e'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '一部のキーが配列に存在しない場合は false を返す必要があります。');
    }

    /**
     * `ArrayKeysRule::passes` メソッドは、空配列のキーを指定された場合に true を返すべきです。
     */
    #[Test]
    public function 空配列のキーが指定された場合にtrueを返す()
    {
        $instance = new ArrayKeysRule();
        $attribute = 'test';
        $value = ['a', 'b', 'c'];
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '空配列のキーが指定された場合に true が返される必要があります。');
    }

    /**
     * `ArrayKeysRule::passes` メソッドは、`$value` が配列でない場合に false を返すべきです。
     */
    #[Test]
    public function valueが配列でない場合にfalseを返す()
    {
        $instance = new ArrayKeysRule();
        $attribute = 'test';
        $value = 'not_an_array';
        $parameters = $this->createParameter([]);
        $arguments = ['key'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '`$value` が配列でない場合に false を返す必要があります。');
    }

}