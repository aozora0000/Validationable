<?php

namespace Tests\Unit\Validationable\Rules;

use Carbon\Carbon;
use DateTime;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\FutureRule;

class FutureRuleTest extends TestCase
{
    /**
     * FutureRule::passes は null の値を false として扱います。
     */
    #[Test]
    public function nullを検証する(): void
    {
        $instance = new FutureRule();
        $value = null;
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, 'null の値が渡された場合、false が期待されます。');
    }

    /**
     * FutureRule::passes は日付文字列が未来の日付の場合 true を返します。
     */
    #[Test]
    public function 日付文字列の未来日付を検証する(): void
    {
        $instance = new FutureRule();
        $value = (Carbon::tomorrow())->format('Y-m-d H:i:s');
        $parameters = $this->createParameter([]);
        $arguments = [(Carbon::now())->format('Y-m-d H:i:s')];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertTrue($actual, '日付文字列が未来の日付の場合、true が必要です。');
    }

    /**
     * FutureRule::passes は日付文字列が過去の日付の場合 false を返します。
     */
    #[Test]
    public function 日付文字列の過去日付を検証する(): void
    {
        $instance = new FutureRule();
        $value = (Carbon::yesterday())->format('Y-m-d H:i:s');
        $parameters = $this->createParameter([]);
        $arguments = [(Carbon::now())->format('Y-m-d H:i:s')];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, '日付文字列が過去の日付の場合、false が期待されます。');
    }

    /**
     * FutureRule::passes は DateTime オブジェクトが未来の日付の場合 true を返します。
     */
    #[Test]
    public function DateTimeオブジェクトの未来日付を検証する(): void
    {
        $instance = new FutureRule();
        $value = Carbon::tomorrow();
        $parameters = $this->createParameter([]);
        $arguments = ['now'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertTrue($actual, 'DateTime オブジェクトが未来の日付の場合、true が期待されます。');
    }

    /**
     * FutureRule::passes は DateTime オブジェクトが過去の日付の場合 false を返します。
     */
    #[Test]
    public function DateTimeオブジェクトの過去日付を検証する(): void
    {
        $instance = new FutureRule();
        $value = Carbon::yesterday();
        $parameters = $this->createParameter([]);
        $arguments = ['now'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, 'DateTime オブジェクトが過去の日付の場合、false が期待されます。');
    }

    /**
     * FutureRule::passes は無効な値を false として扱います。
     */
    #[Test]
    public function 無効な値を検証する(): void
    {
        $instance = new FutureRule();
        $value = 'invalid_date';
        $parameters = $this->createParameter([]);
        $arguments = [(Carbon::now())->format('Y-m-d H:i:s')];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, '無効な値が渡された場合、false が期待されます。');
    }

    /**
     * FutureRule::passes はデフォルトで現在の日付を基準として検証します。
     */
    #[Test]
    public function デフォルト日付基準を検証する(): void
    {
        $instance = new FutureRule();
        $value = Carbon::tomorrow();
        $parameters = $this->createParameter([]);
        $arguments = []; // 基準日付未指定

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertTrue($actual, '基準日付が指定されない場合でも、現在の日付を基準に未来の日付と判断する必要があります。');
    }
}