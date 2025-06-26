<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\SlugRule;

class SlugRuleTest extends TestCase
{
    #[Test]
    public function 正当なスラッグの場合はtrueを返す(): void
    {
        $rule = new SlugRule();
        $this->assertTrue($rule->passes('slug', 'this-is-a-valid-slug', $this->createParameter([])));
    }

    #[Test]
    public function 数字を含む正当なスラッグの場合はtrueを返す(): void
    {
        $rule = new SlugRule();
        $this->assertTrue($rule->passes('slug', 'another-slug123', $this->createParameter([])));
    }

    #[Test]
    public function ハイフンを含まない単一の単語のスラッグの場合はtrueを返す(): void
    {
        $rule = new SlugRule();
        $this->assertTrue($rule->passes('slug', 'slug', $this->createParameter([])));
    }

    #[Test]
    public function 大文字が含まれる場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 'Invalid-slug', $this->createParameter([])));
    }

    #[Test]
    public function アンダースコアが含まれる場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 'invalid_slug', $this->createParameter([])));
    }

    #[Test]
    public function スペースが含まれる場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 'invalid slug', $this->createParameter([])));
    }

    #[Test]
    public function 先頭がハイフンの場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', '-invalid-slug', $this->createParameter([])));
    }

    #[Test]
    public function 末尾がハイフンの場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 'invalid-slug-', $this->createParameter([])));
    }

    #[Test]
    public function 連続したハイフンが含まれる場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 'invalid--slug', $this->createParameter([])));
    }

    #[Test]
    public function 数値の場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', 123, $this->createParameter([])));
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', null, $this->createParameter([])));
    }

    #[Test]
    public function boolの場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', true, $this->createParameter([])));
    }

    #[Test]
    public function 配列の場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', [], $this->createParameter([])));
    }

    #[Test]
    public function 空文字列の場合はfalseを返す(): void
    {
        $rule = new SlugRule();
        $this->assertFalse($rule->passes('slug', '', $this->createParameter([])));
    }
}
