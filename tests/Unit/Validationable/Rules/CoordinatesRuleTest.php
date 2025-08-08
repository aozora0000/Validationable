<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\CoordinatesRule;

class CoordinatesRuleTest extends TestCase
{
    #[Test]
    public function 正しい範囲の座標はtrue(): void
    {
        $instance = new CoordinatesRule();
        $this->assertTrue($instance->passes('pos', '35.0,139.0', $this->createParameter([])), '正しい範囲の座標はtrue');
    }

    #[Test]
    public function 範囲外はfalse(): void
    {
        $instance = new CoordinatesRule();
        $this->assertFalse($instance->passes('pos', '100.0,200.0', $this->createParameter([])), '範囲外はfalse');
    }
}
