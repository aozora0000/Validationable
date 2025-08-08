<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\PostalCodeRule;

class PostalCodeRuleTest extends TestCase
{
    #[Test]
    public function ハイフン付き7桁はtrue(): void
    {
        $instance = new PostalCodeRule();
        $this->assertTrue($instance->passes('zip', '123-4567', $this->createParameter([])), '123-4567はtrue');
    }

    #[Test]
    public function 桁不足はfalse(): void
    {
        $instance = new PostalCodeRule();
        $this->assertFalse($instance->passes('zip', '123-456', $this->createParameter([])), '桁不足はfalse');
    }
}
