<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\MimeTypeByContentRule;

class MimeTypeByContentRuleTest extends TestCase
{
    #[Test]
    public function 許可MIMEに一致する場合はtrue(): void
    {
        // このリポジトリのcomposer.jsonをtext/plainとして判定する環境が多い
        $path = __DIR__ . '/../../../../composer.json';
        $instance = new MimeTypeByContentRule();
        $this->assertTrue($instance->passes('file', $path, $this->createParameter([]), ['application/json','text/plain']), '許可MIMEに含まれればtrue');
    }

    #[Test]
    public function 存在しないファイルはfalse(): void
    {
        $path = __DIR__ . '/no_such_file_12345.txt';
        $instance = new MimeTypeByContentRule();
        $this->assertFalse($instance->passes('file', $path, $this->createParameter([]), ['text/plain']), '存在しないファイルはfalse');
    }
}
