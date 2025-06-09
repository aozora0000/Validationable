<?php

namespace Tests\Unit\Validationable\Rules;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\UniqueRule;

class UniqueRuleTest extends TestCase
{
    /**
     * ユニークチェックが成功する場合
     */
    #[Test]
    public function ユニークチェックが成功する場合(): void
    {
        $instance = new UniqueRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'value', $parameters, ['unique_value1', 'unique_value2']);

        $this->assertTrue($actual, 'ユニーク検証が失敗しましたが、成功する必要があります。');
    }

    /**
     * ユニークチェックが失敗する場合
     */
    #[Test]
    public function ユニークチェックが失敗する場合(): void
    {
        $instance = new UniqueRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'duplicate_value', $parameters, ['duplicate_value', 'other_value']);

        $this->assertFalse($actual, 'ユニーク検証が成功しましたが、失敗する必要があります。');
    }

    /**
     * 引数が空の場合例外が発生する
     */
    #[Test]
    public function 引数が空の場合例外が発生する(): void
    {
        $instance = new UniqueRule();
        $parameters = $this->createParameter([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unique rule requires at least one argument');

        $instance->passes('attribute', 'value', $parameters, []);
    }
}