<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HiraganaRule;

class HiraganaRuleTest extends TestCase
{
    #[Test]
    public function ひらがなのみならtrue(): void
    {
        $instance = new HiraganaRule();
        $this->assertTrue($instance->passes('kana', 'ひらがな ー', $this->createParameter([])), 'ひらがなのみはtrue');
    }

    #[Test]
    public function カタカナ混在はfalse(): void
    {
        $instance = new HiraganaRule();
        $this->assertFalse($instance->passes('kana', 'カタカナ', $this->createParameter([])), 'カタカナ混在はfalse');
    }
}
