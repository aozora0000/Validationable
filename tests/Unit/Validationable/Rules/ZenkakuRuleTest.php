<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ZenkakuRule;

class ZenkakuRuleTest extends TestCase
{
    #[Test]
    public function 全角のみはtrue(): void
    {
        $instance = new ZenkakuRule();
        $this->assertTrue($instance->passes('s', 'ＡＢＣ１２３（テスト）', $this->createParameter([])), '全角のみはtrue');
    }

    #[Test]
    public function 半角混在はfalse(): void
    {
        $instance = new ZenkakuRule();
        $this->assertFalse($instance->passes('s', 'ABCテスト', $this->createParameter([])), '半角混在はfalse');
    }
}
