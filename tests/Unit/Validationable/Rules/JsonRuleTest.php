<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\JsonRule;

class JsonRuleTest extends TestCase
{
    #[Test]
    public function 合法なJson文字列を渡すとtrueを返す()
    {
        $instance = new JsonRule();
        $value = '{"key": "value"}';
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', $value, $params);

        $this->assertTrue($actual, '合法な JSON 文字列が正しく判定されていません。');
    }

    #[Test]
    public function 空文字列を渡すとfalseを返す()
    {
        $instance = new JsonRule();
        $value = '';
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', $value, $params);

        $this->assertFalse($actual, '空文字列が JSON として誤って判定されています。');
    }

    #[Test]
    public function 無効なJson文字列を渡すとfalseを返す()
    {
        $instance = new JsonRule();
        $value = '{key: value}';
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', $value, $params);

        $this->assertFalse($actual, '無効な JSON 文字列が正しく判定されていません。');
    }


    #[Test]
    public function nullを渡すとfalseを返す()
    {
        $instance = new JsonRule();
        $value = null;
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', $value, $params);

        $this->assertFalse($actual, 'null が JSON として誤って判定されています。');
    }

    #[Test]
    public function 配列表記のJson文字列を渡すとtrueを返す()
    {
        $instance = new JsonRule();
        $value = '["item1", "item2"]';
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', $value, $params);

        $this->assertTrue($actual, '配列の JSON 文字列が正しく判定されていません。');
    }
}