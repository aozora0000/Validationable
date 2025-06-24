<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\PasswordStrengthRule;

class PasswordStrengthRuleTest extends TestCase
{
    #[Test]
    public function strong基準で12文字未満のパスワードはfalseを返す()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', 'Aa1!', $parameters, ['strong']);

        $this->assertFalse($actual, '12文字未満のパスワードで強さ判定に失敗しました。');
    }

    #[Test]
    public function medium基準で8文字未満のパスワードはfalseを返す()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', 'Aa1!', $parameters, ['medium']);

        $this->assertFalse($actual, '12文字未満のパスワードで中強度判定に失敗しました。');
    }

    #[Test]
    public function エントロピー計算でStrong基準のパスワードが適切に判定される()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', 'AG1!B%2@Zc3#*d$G', $parameters, ['strong']);

        $this->assertTrue($actual, 'エントロピーに基づく強度判定で失敗しました (strong基準)。');
    }

    #[Test]
    public function エントロピー計算でMedium基準のパスワードが適切に判定される()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', 'Aa1!Bb2@cC#*D', $parameters, ['medium']);

        $this->assertTrue($actual, 'エントロピーに基づく強度判定で失敗しました (medium基準)。');
    }

    #[Test]
    public function エントロピー計算でWeak基準のパスワードが適切に判定される()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', 'Aa1Bb2Cc34De', $parameters, ['weak']);

        $this->assertTrue($actual, 'エントロピーに基づく強度判定で失敗しました (weak基準)。');
    }

    #[Test]
    public function 空のパスワードはfalseを返す()
    {
        $instance = new PasswordStrengthRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('password', '', $parameters, ['strong']);

        $this->assertFalse($actual, '空のパスワードの判定で失敗しました。');
    }
}