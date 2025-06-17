<?php

namespace Tests\Unit\Validationable;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rule;

class RuleTest extends TestCase
{
    #[Test]
    public function Enumで特定の値があった場合Trueを返す(): void
    {
        $instance = Rule::enum(TestEnum::class);
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', TestEnum::A, $params, []);
        $this->assertTrue($actual);
    }

    #[Test]
    public function Enumで特定の値があるが排他処理されている場合Falseを返す(): void
    {
        $instance = Rule::enum(TestEnum::class)->expect([
            TestEnum::A,
        ]);
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', TestEnum::A, $params, []);
        $this->assertFalse($actual);
    }

    #[Test]
    public function Enumで特定の値があり排他処理されていない場合Falseを返す(): void
    {
        $instance = Rule::enum(TestEnum::class)->expect([
            TestEnum::B,
        ]);
        $params = $this->createParameter([]);
        $actual = $instance->passes('test', TestEnum::A, $params, []);
        $this->assertTrue($actual);
    }
}