<?php

namespace Tests\Unit\Validationable;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
use Validationable\Rule;

class ParametersTest extends TestCase
{
    #[Test]
    public function ルールがマクロ登録されているかチェック(): void
    {
        $macros = Parameters::$rules;
        $files = glob(__DIR__ . '/../../../src/Rules/*.php');

        // ファイル名からクラス名を抽出
        $fileClasses = array_map(fn($file): string => basename($file, '.php'), $files);

        // マクロ配列のキーを取得
        $macroNames = array_map(fn($class): string => substr($class, strrpos($class, '\\') + 1), array_values($macros));
        // 差分を検出
        $missingInMacros = array_diff($fileClasses, $macroNames);
        $missingInFiles = array_diff($macroNames, $fileClasses);

        // テストメッセージを作成
        $errorMessage = '';
        if ($missingInMacros !== []) {
            $errorMessage .= "マクロに実装されていないファイルが存在します: " . implode(', ', $missingInMacros) . "\n";
        }

        if ($missingInFiles !== []) {
            $errorMessage .= "ファイルが存在しないマクロが定義されています: " . implode(', ', $missingInFiles);
        }

        $this->assertEmpty($errorMessage, $errorMessage);
    }

    #[Test]
    public function コールバックバリデーションが機能しているかチェック(): void
    {
        $validation = new class(['test' => 'test']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => [Rule::callback(fn($attribute, $value, $parameters): bool => $value === 'test')],
                ];
            }
        };
        $this->assertTrue($validation->passes());
    }

    #[Test]
    public function 存在しないバリデーションが指定されていると例外が投げられる(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The rule [invalidRule] does not exist.');
        $validation = new class(['test' => 'test']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['invalidRule'],
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

    #[Test]
    public function Not構文が機能しているかチェック(): void
    {
        $validation = new class(['test' => '1']) extends Parameters {
            public function rules(): array
            {
                return [
                    'test' => ['required', '!integer'],
                ];
            }
        };
        $this->assertFalse($validation->passes());
    }
}