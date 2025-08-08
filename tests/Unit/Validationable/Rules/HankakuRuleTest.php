<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HankakuRule;

class HankakuRuleTest extends TestCase
{
    #[Test]
    public function 半角のみはtrue(): void
    {
        $instance = new HankakuRule();
        $this->assertTrue($instance->passes('s', 'ABC123-_.', $this->createParameter([])), '半角のみはtrue');
    }

    #[Test]
    public function 全角混在はfalse(): void
    {
        $instance = new HankakuRule();
        $this->assertFalse($instance->passes('s', 'ＡＢＣ', $this->createParameter([])), '全角混在はfalse');
    }
}
