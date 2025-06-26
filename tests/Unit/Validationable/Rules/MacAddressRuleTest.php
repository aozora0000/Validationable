<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\MacAddressRule;

class MacAddressRuleTest extends TestCase
{
    /**
     * MacAddressRule::passes() メソッドのテスト:
     * MACアドレスの形式が正しい場合、trueが返されることを確認します。
     */
    #[Test]
    public function macアドレスが正しい場合(): void
    {
        $instance = new MacAddressRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('mac_address', '00:1A:2B:3C:4D:5E', $parameters);

        $this->assertTrue($actual, 'MACアドレスの形式が正しい場合、trueが返されるべきです。');
    }

    /**
     * MacAddressRule::passes() メソッドのテスト:
     * MACアドレスの形式が不正な場合、falseが返されることを確認します。
     */
    #[Test]
    public function macアドレスが不正の場合(): void
    {
        $instance = new MacAddressRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('mac_address', '00-1A:2B-3C:4D-5E', $parameters);

        $this->assertFalse($actual, 'MACアドレスの形式が不正な場合、falseが返されるべきです。');
    }

    /**
     * MacAddressRule::passes() メソッドのテスト:
     * 値が文字列ではない場合、falseが返されることを確認します。
     */
    #[Test]
    public function 値が文字列ではない場合(): void
    {
        $instance = new MacAddressRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('mac_address', 12345, $parameters);

        $this->assertFalse($actual, '値が文字列でない場合、falseが返されるべきです。');
    }

    /**
     * MacAddressRule::passes() メソッドのテスト:
     * 空の文字列が渡された場合、falseが返されることを確認します。
     */
    #[Test]
    public function 空の値の場合(): void
    {
        $instance = new MacAddressRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('mac_address', '', $parameters);

        $this->assertFalse($actual, '空の文字列が渡される場合、falseが返されるべきです。');
    }

    /**
     * MacAddressRule::passes() メソッドのテスト:
     * 値がMACアドレスのフォーマットではない無効な文字列の場合、falseが返されることを確認します。
     */
    #[Test]
    public function 無効な文字列の場合(): void
    {
        $instance = new MacAddressRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('mac_address', 'invalidMacAddress', $parameters);

        $this->assertFalse($actual, '無効なMACアドレス形式の文字列が渡される場合、falseが返されるべきです。');
    }
}