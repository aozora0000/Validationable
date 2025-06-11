<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\Arr;
use Validationable\Rules\DistinctRule;

class DistinctRuleTest extends TestCase
{
    #[Test]
    public function 値がユニークな場合_真を返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new DistinctRule();

        // テストするデータ
        $attribute = 'example';
        $value = [1, 2, 3, 4];
        $parameters = $this->createParameter([]);

        // 結果を期待値と比較
        $this->assertTrue(
            $instance->passes($attribute, $value, $parameters),
            '値がユニークな場合、真を返すべきです。'
        );
    }

    #[Test]
    public function 値が重複している場合_偽を返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new DistinctRule();

        // テストするデータ
        $attribute = 'example';
        $value = [1, 2, 2, 4];
        $parameters = $this->createParameter([]);

        // 結果を期待値と比較
        $this->assertFalse(
            $instance->passes($attribute, $value, $parameters),
            '値が重複している場合、偽を返すべきです。'
        );
    }

    #[Test]
    public function 空配列の場合_真を返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new DistinctRule();

        // テストするデータ
        $attribute = 'example';
        $value = [];
        $parameters = $this->createParameter([]);

        // 結果を期待値と比較
        $this->assertTrue(
            $instance->passes($attribute, $value, $parameters),
            '空配列の場合、真を返すべきです。'
        );
    }

    #[Test]
    public function 値が配列ではない場合_偽を返す()
    {
        // 値が配列でない場合を模擬するためにArr::ofメソッドをモック
        $arrMock = $this->createMock(Arr::class);
        $arrMock->method('of')->willReturn(false);

        // テスト対象のインスタンスを作成
        $instance = new DistinctRule();

        // テストするデータ
        $attribute = 'example';
        $value = 'not_array';
        $parameters = $this->createParameter([]);

        // 結果を期待値と比較
        $this->assertFalse(
            $instance->passes($attribute, $value, $parameters),
            '値が配列でない場合、偽を返すべきです。'
        );
    }

    #[Test]
    public function 値がnullの場合_偽を返す()
    {
        // テスト対象のインスタンスを作成
        $instance = new DistinctRule();

        // テストするデータ
        $attribute = 'example';
        $value = null;
        $parameters = $this->createParameter([]);

        // 結果を期待値と比較
        $this->assertFalse(
            $instance->passes($attribute, $value, $parameters),
            '値がnullの場合、偽を返すべきです。'
        );
    }
}