<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\CountryCodeRule;

class CountryCodeRuleTest extends TestCase
{
    #[Test]
    public function 有効な国コードはtrueを返す(): void
    {
        $instance = new CountryCodeRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('country', 'US', $parameters);

        $this->assertTrue($actual, '有効な国コードでtrueが返されませんでした。');
    }

    #[Test]
    public function 無効な国コードはfalseを返す(): void
    {
        $instance = new CountryCodeRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('country', 'INVALID_CODE', $parameters);

        $this->assertFalse($actual, '無効な国コードでfalseが返されませんでした。');
    }

    #[Test]
    public function 空の値はfalseを返す(): void
    {
        $instance = new CountryCodeRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('country', '', $parameters);

        $this->assertFalse($actual, '空の値でfalseが返されませんでした。');
    }
}