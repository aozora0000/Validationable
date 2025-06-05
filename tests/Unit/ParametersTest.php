<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Validationable\Parameters;
use Validationable\Rule;

class ParametersTest extends TestCase
{
    #[Test]
    public function コールバックバリデーションが機能しているかチェック(): void
    {
        $validation = new class(['test' => 'test']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => [Rule::callback(fn($attribute, $value, $parameters) => $value === 'test')],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }
    #[Test]
    public function セミコロン付きバリデーションが機能しているかチェック(): void
    {
        $values = ['test' => 'test', 'test2' => true];
        $validation = new class($values) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['required_if:test2'],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }

    #[Test]
    public function Requiredが機能しているかチェック(): void
    {
        $validation = new class(['test' => 'test']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['required'],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }

    #[Test]
    public function Sometimesで値がある場合機能しているかチェック(): void
    {
        $validation = new class(['test' => '1']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['sometimes', 'integer'],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }

    #[Test]
    public function Sometimesで値がない場合機能しているかチェック(): void
    {
        $validation = new class([]) extends Parameters {
            public function rules(): array
            {
                return [
                    'test2' => ['sometimes', 'integer'],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }

    #[Test]
    public function Integerが機能しているかチェック(): void
    {
        $validation = new class(['test' => '1']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['required', 'integer'],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }
}