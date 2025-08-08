<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\SafeFilenameRule;

class SafeFilenameRuleTest extends TestCase
{
    #[Test]
    public function 許可文字のみのファイル名はtrue(): void
    {
        $instance = new SafeFilenameRule();
        $this->assertTrue($instance->passes('name', 'safe-file_01.txt', $this->createParameter([])), '安全なファイル名はtrue');
    }

    #[Test]
    public function スラッシュを含むとfalse(): void
    {
        $instance = new SafeFilenameRule();
        $this->assertFalse($instance->passes('name', 'unsafe/name.txt', $this->createParameter([])), 'パス区切りはfalse');
    }
}
