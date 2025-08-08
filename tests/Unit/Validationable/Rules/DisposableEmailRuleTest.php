<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\DisposableEmailRule;

class DisposableEmailRuleTest extends TestCase
{
    #[Test]
    public function ブロックリスト外のドメインはtrue(): void
    {
        $instance = new DisposableEmailRule();
        $this->assertTrue($instance->passes('email', 'user@example.com', $this->createParameter([])), '通常ドメインはtrue');
    }

    #[Test]
    public function ブロックリストドメインはfalse(): void
    {
        $instance = new DisposableEmailRule();
        $this->assertFalse($instance->passes('email', 'user@mailinator.com', $this->createParameter([])), '使い捨てドメインはfalse');
    }
}
