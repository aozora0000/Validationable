<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\Str;
use Validationable\Rules\CallableRule;

class CallableRuleTest extends TestCase
{
    /**
     * CallableRule::passes メソッドの正常ケース（有効な関数が提供された場合）。
     */
    #[Test]
    public function 有効な関数で成功する(): void
    {
        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = ['string' => 'test'];
        $arguments = ['strlen'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertTrue($actual, 'CallableRule::passes メソッドは有効な引数で true を返す必要があります。');
    }

    /**
     * CallableRule::passes メソッドの正常ケース（有効なメソッドが提供された場合）。
     */
    #[Test]
    public function 有効なメソッドで成功する(): void
    {
        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = ['value' => 'test'];
        $arguments = [Str::class . '::isInteger'];;

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertTrue($actual, 'CallableRule::passes メソッドは有効な引数で true を返す必要があります。');
    }

    /**
     * CallableRule::passes メソッドの異常ケース（引数が空の場合）。
     */
    #[Test]
    public function 引数が空の場合例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('CallableRule rule requires at least one argument');

        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = ['input1' => 5];

        $instance->passes('test_attribute', $value, $parameters, []);
    }

    /**
     * CallableRule::passes メソッドの異常ケース（無効なクラスメソッド）。
     */
    #[Test]
    public function 無効なクラスメソッドで例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('CallableRule rule requires a valid class name');

        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = ['input1' => 5];
        $arguments = ['InvalidFunction::method'];

        $instance->passes('test_attribute', $value, $parameters, $arguments);
    }

    /**
     * CallableRule::passes メソッドの異常ケース（値が配列ではない場合）。
     */
    #[Test]
    public function 値が配列でない場合失敗する(): void
    {
        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = 'not_an_array';
        $arguments = ['strlen'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, 'CallableRule::passes メソッドは値が配列でない場合 false を返す必要があります。');
    }

    /**
     * CallableRule::passes メソッドの異常ケース（関数の引数が一致しない場合）。
     */
    #[Test]
    public function 関数の引数が一致しない場合失敗する(): void
    {
        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = ['incorrect_param' => 5];
        $arguments = ['strlen'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, 'CallableRule::passes メソッドの引数が一致しない場合 false を返す必要があります。');
    }

    /**
     * CallableRule::passes メソッドの異常ケース（実行時エラーが発生した場合）。
     */
    #[Test]
    public function 実行時エラーが発生した場合失敗する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('CallableRule rule requires a valid class name');


        $instance = new CallableRule();
        $parameters = $this->createParameter([]);
        $value = [];
        $arguments = ['invalid_function'];

        $actual = $instance->passes('test_attribute', $value, $parameters, $arguments);
    }
}