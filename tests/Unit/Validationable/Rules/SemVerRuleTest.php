<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\SemVerRule;

class SemVerRuleTest extends TestCase
{
    #[Test]
    public function 有効なバージョンの場合はtrueを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertTrue($rule->passes('version', '1.0.0', $this->createParameter([])));
    }

    #[Test]
    public function プレリリースバージョンの場合はtrueを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertTrue($rule->passes('version', '1.0.0-alpha', $this->createParameter([])));
    }

    #[Test]
    public function プレリリースとドット付きバージョンの場合はtrueを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertTrue($rule->passes('version', '1.0.0-alpha.1', $this->createParameter([])));
    }

    #[Test]
    public function ビルドメタデータ付きの場合はtrueを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertTrue($rule->passes('version', '1.0.0+build.1', $this->createParameter([])));
    }

    #[Test]
    public function プレリリースとビルドメタデータ付きの場合はtrueを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertTrue($rule->passes('version', '1.0.0-alpha.1+build.1', $this->createParameter([])));
    }

    #[Test]
    public function 無効なバージョンの場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', '1.0', $this->createParameter([])));
    }

    #[Test]
    public function 先頭にvが付いている場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', 'v1.0.0', $this->createParameter([])));
    }

    #[Test]
    public function 先頭に0が付いている場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', '1.01.0', $this->createParameter([])));
    }

    #[Test]
    public function 文字列以外の値の場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', 123, $this->createParameter([])));
    }

    #[Test]
    public function null値の場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', null, $this->createParameter([])));
    }

    #[Test]
    public function 空文字の場合はfalseを返す(): void
    {
        $rule = new SemVerRule();
        $this->assertFalse($rule->passes('version', '', $this->createParameter([])));
    }

    #[Test]
    public function 有効なバージョン制約の場合はtrueを返す(): void
    {
        $instance = new SemVerRule();
        $this->assertTrue(
            $instance->passes('version', '1.2.3', $this->createParameter([]), ['^1.0']),
            '有効な制約 ^1.0 を持つバージョン 1.2.3 が検証に失敗しました。'
        );
    }

    #[Test]
    public function 無効なバージョン制約の場合はfalseを返す(): void
    {
        $instance = new SemVerRule();
        $this->assertFalse(
            $instance->passes('version', '2.0.0', $this->createParameter([]), ['^1.0']),
            '無効な制約 ^1.0 を持つバージョン 2.0.0 が検証に成功しました。'
        );
    }
}