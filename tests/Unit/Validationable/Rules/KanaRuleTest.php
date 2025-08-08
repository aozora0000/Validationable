<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\KanaRule;

class KanaRuleTest extends TestCase
{
    #[Test]
    public function 仮名のみならtrue(): void
    {
        $instance = new KanaRule();
        $this->assertTrue($instance->passes('kana', 'カタカナ かなー', $this->createParameter([])), '仮名のみはtrue');
    }

    #[Test]
    public function 英字混在はfalse(): void
    {
        $instance = new KanaRule();
        $this->assertFalse($instance->passes('kana', 'カタカナA', $this->createParameter([])), '英字混在はfalse');
    }
}
