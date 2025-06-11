<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\TimeZoneRule;

class TimeZoneRuleTest extends TestCase
{
    #[Test]
    public function 有効なタイムゾーンが渡された場合にtrueを返す(): void
    {
        // テストデータの準備
        $instance = new TimeZoneRule();
        $attribute = 'timezone';
        $value = 'Europe/London';
        $parameters = $this->createParameter([]);
        $arguments = [];


        // 実行コード
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertTrue($actual, '有効なタイムゾーンの値が渡された場合にはtrueが返されるべきです。');
    }

    #[Test]
    public function 無効なタイムゾーンが渡された場合にfalseを返す(): void
    {
        // テストデータの準備
        $instance = new TimeZoneRule();

        $attribute = 'timezone';
        $value = 'Invalid/Timezone';
        $parameters = $this->createParameter([]);
        $arguments = [];


        // 実行コード
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, '無効なタイムゾーンの値が渡された場合にはfalseが返されるべきです。');
    }

    #[Test]
    public function 有効なタイムゾーンが引数に含まれている場合にtrueを返す(): void
    {
        // テストデータの準備
        $instance = new TimeZoneRule();

        $attribute = 'timezone';
        $value = 'Custom/Timezone';
        $parameters = $this->createParameter([]);
        $arguments = ['Custom/Timezone'];


        // 実行コード
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertTrue($actual, '有効なタイムゾーンが引数リストに含まれている場合にはtrueが返されるべきです。');
    }

    #[Test]
    public function 空の値が渡された場合にfalseを返す(): void
    {
        // テストデータの準備
        $instance = new TimeZoneRule();

        $attribute = 'timezone';
        $value = '';
        $parameters = $this->createParameter([]);
        $arguments = [];


        // 実行コード
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, '空の値が渡された場合にはfalseが返されるべきです。');
    }

    #[Test]
    public function 引数やリストに値が含まれていない場合にfalseを返す(): void
    {
        // テストデータの準備
        $instance = new TimeZoneRule();

        $attribute = 'timezone';
        $value = 'Custom/Tokyo';
        $parameters = $this->createParameter([]);
        $arguments = ['Custom/Timezone'];


        // 実行コード
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, '引数やリストの中に値が含まれていない場合にはfalseが返されるべきです。');
    }
}