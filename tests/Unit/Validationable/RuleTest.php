<?php

namespace Tests\Unit\Validationable;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
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

    #[Test]
    public function WhenでonSuccessが実行され且つ結果が真の場合(): void
    {
        $params = new class(['test' => 2]) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => Rule::when(['integer'], ['between:1,100'], ['starts_with:test']),
                ];
            }
        };
        $actual = $params->passes();
        $this->assertTrue($actual);
    }

    #[Test]
    public function WhenでonSuccessが実行され且つ結果が偽の場合(): void
    {
        // WIP
        $this->markTestSkipped('ここ途中');
        $params = new class(['test' => 101]) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => Rule::when(['integer'], ['between:1,100'], ['starts_with:test']),
                ];
            }
        };
        $actual = $params->passes();
        $this->assertFalse($actual);
    }

    #[Test]
    public function WhenでonFailedが実行され且つ結果が真の場合(): void
    {
        // WIP
        $this->markTestSkipped('ここ途中');
        $params = new class(['test' => 'test_a']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => Rule::when(['integer'], ['between:1,100'], ['starts_with:test']),
                ];
            }
        };
        $actual = $params->passes();
        $this->assertFalse($actual);
    }

    #[Test]
    public function WhenでonFailedが実行され且つ結果が偽の場合(): void
    {
        $params = new class(['test' => 'a']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => Rule::when(['integer'], ['between:1,100'], ['starts_with:test']),
                ];
            }
        };
        $actual = $params->passes();
        $this->assertFalse($actual);
    }
}