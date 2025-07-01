<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\FileExistsRule;

class FileExistsRuleTest extends TestCase
{
    #[Test]
    public function ファイルが存在する場合テスト(): void
    {
        // テスト対象のクラスを初期化
        $instance = new FileExistsRule();

        // テスト用の一時ファイルを作成
        $testFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_file.txt';
        file_put_contents($testFilePath, 'test content');


        $params = $this->createParameter([]);
        // メソッドを呼び出して結果を取得
        $actual = $instance->passes('file', $testFilePath, $params);

        // アサーション
        $this->assertTrue($actual, 'ファイルが存在するとき、passesメソッドはtrueを返す必要があります。');

        // テスト後に一時ファイルを削除
        unlink($testFilePath);
    }

    #[Test]
    public function ファイルが存在しない場合テスト(): void
    {
        // テスト対象のクラスを初期化
        $instance = new FileExistsRule();

        // 存在しないファイルパス
        $nonExistentFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'non_existent_file.txt';


        $params = $this->createParameter([]);
        // メソッドを呼び出して結果を取得
        $actual = $instance->passes('file', $nonExistentFilePath, $params);

        // アサーション
        $this->assertFalse($actual, 'ファイルが存在しないとき、passesメソッドはfalseを返す必要があります。');
    }

    #[Test]
    public function 不正な値の場合例外テスト(): void
    {
        // テスト対象のクラスを初期化
        $instance = new FileExistsRule();

        // 不正な値
        $invalidValue = null;

        // 例外の期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The exists rule requires at least 1 argument.');

        $params = $this->createParameter([]);
        // メソッドを呼び出し
        $instance->passes('file', $invalidValue, $params);
    }
}