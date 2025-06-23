<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\UuidRule;

class UuidRuleTest extends TestCase
{
    #[Test]
    public function UUID形式である場合に成功する(): void
    {
        $instance = new UuidRule();
        $parameters = $this->createParameter([]);

        $value = '123e4567-e89b-12d3-a456-426614174000'; // UUID

        $result = $instance->passes('test', $value, $parameters);

        $this->assertTrue($result, 'UUIDとして正しい形式のデータで失敗しました');
    }

    #[Test]
    public function UUID形式でない場合に失敗する(): void
    {
        $instance = new UuidRule();
        $parameters = $this->createParameter([]);

        $value = 'invalid-uuid-value';

        $result = $instance->passes('test', $value, $parameters);

        $this->assertFalse($result, 'UUIDではない形式のデータが成功と判定されました');
    }

    #[Test]
    public function 空文字の場合に失敗する(): void
    {
        $instance = new UuidRule();
        $parameters = $this->createParameter([]);

        $value = '';

        $result = $instance->passes('test', $value, $parameters);

        $this->assertFalse($result, '空文字がUUIDとして成功と判定されました');
    }

    #[Test]
    public function nullの場合に失敗する(): void
    {
        $instance = new UuidRule();
        $parameters = $this->createParameter([]);

        $value = null;

        $result = $instance->passes('test', $value, $parameters);

        $this->assertFalse($result, 'null値がUUIDとして成功と判定されました');
    }

    #[Test]
    public function 特殊文字列を含む値が失敗する(): void
    {
        $instance = new UuidRule();
        $parameters = $this->createParameter([]);

        $value = '123e4567-g89b-12d3-a456-426614174000'; // 不正なUUID

        $result = $instance->passes('test', $value, $parameters);

        $this->assertFalse($result, '特殊文字列を含む不正なUUIDが成功と判定されました');
    }
}