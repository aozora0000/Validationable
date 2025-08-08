<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\UnicodeNormalizationRule;

class UnicodeNormalizationRuleTest extends TestCase
{
    #[Test]
    public function NFC正規化済みならtrueになる(): void
    {
        // ひらがな+記号（既にNFCであることが多い）
        $instance = new UnicodeNormalizationRule();
        $this->assertTrue($instance->passes('name', 'あいうえお', $this->createParameter([])), 'NFC正規化済みの文字列はtrue');
    }

    #[Test]
    public function 文字列以外や空はfalseになる(): void
    {
        $instance = new UnicodeNormalizationRule();
        $this->assertFalse($instance->passes('name', '', $this->createParameter([])), '空文字はfalse');
    }
}
