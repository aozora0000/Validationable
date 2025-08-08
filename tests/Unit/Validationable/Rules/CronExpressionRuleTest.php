<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\CronExpressionRule;

class CronExpressionRuleTest extends TestCase
{
    #[Test]
    public function 一般的な表現はtrue(): void
    {
        $instance = new CronExpressionRule();
        $this->assertTrue($instance->passes('cron', '*/5 9-17 * * 1-5', $this->createParameter([])), '典型的なcronはtrue');
    }

    #[Test]
    public function フィールド数が不正ならfalse(): void
    {
        $instance = new CronExpressionRule();
        $this->assertFalse($instance->passes('cron', '*/5 9-17 * *', $this->createParameter([])), 'フィールド不足はfalse');
    }
}
