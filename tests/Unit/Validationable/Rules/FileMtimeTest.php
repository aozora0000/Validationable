<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\File;
use Validationable\Rules\FileMtime;

class FileMtimeTest extends TestCase
{
    /**
     * ファイルの最終更新日時が一致する場合
     */
    #[Test]
    public function ファイルの最終更新日時が一致する場合(): void
    {
        $instance = new FileMtime();
        $attribute = 'file';
        $value = __FILE__;
        $parameters = $this->createParameter([]);
        $arguments = ['==' . File::mtime($value)];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'ファイルの最終更新日時が一致しませんでした。');
    }

    /**
     * ファイルの最終更新日時が小さい場合
     */
    #[Test]
    public function ファイルの最終更新日時が小さい場合(): void
    {
        $instance = new FileMtime();
        $attribute = 'file';
        $value = __FILE__;
        $parameters = $this->createParameter([]);
        $arguments = ['<=' . File::mtime($value)];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'ファイルの最終更新日時が小さくありませんでした。');
    }

    /**
     * ファイルの最終更新日時が大きい場合
     */
    #[Test]
    public function ファイルの最終更新日時が大きい場合(): void
    {
        $instance = new FileMtime();
        $attribute = 'file';
        $value = __FILE__;
        $parameters = $this->createParameter([]);
        $arguments = ['>' . (File::mtime($value) + 100)];
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, 'ファイルの最終更新日時が大きいと評価されましたが、期待に反しました。');
    }

    /**
     * 不正な引数付きで例外をスローする場合
     */
    #[Test]
    public function 不正な引数付きで例外をスローする場合(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('FileMtime rule requires at least one argument');

        $instance = new FileMtime();
        $attribute = 'file';
        $value = __FILE__;
        $parameters = $this->createParameter([]);
        $arguments = [];
        $instance->passes($attribute, $value, $parameters, $arguments);
    }

    /**
     * 無効な比較演算子で例外をスローする場合
     */
    #[Test]
    public function 無効な比較演算子で例外をスローする場合(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid comparison operator');

        $instance = new FileMtime();
        $attribute = 'file';
        $value = __FILE__;
        $parameters = $this->createParameter([]);
        $arguments = ['~~~100'];

        $instance->passes($attribute, $value, $parameters, $arguments);
    }
}