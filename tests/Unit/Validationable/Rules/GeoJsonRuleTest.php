<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\GeoJsonRule;

class GeoJsonRuleTest extends TestCase
{
    #[Test]
    public function タイプと座標の値が有効なポイントの場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['type' => 'Point', 'coordinates' => [-100.0, 45.0]]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertTrue($actual, '有効なPointデータが失敗を返しました。');
    }

    #[Test]
    public function 無効なデータの場合は失敗する(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = 'invalid data';

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '無効なデータが成功を返しました。');
    }

    #[Test]
    public function 型が指定されているが一致しない場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['type' => 'Point', 'coordinates' => [-100.0, 45.0]]);
        $arguments = ['LineString'];

        $actual = $instance->passes('attribute', $value, $parameters, $arguments);

        $this->assertFalse($actual, '指定された型と一致しないデータが成功を返しました。');
    }

    #[Test]
    public function 座標が不足している場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['type' => 'Point', 'coordinates' => [45.0]]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '座標が不足しているデータが成功を返しました。');
    }

    #[Test]
    public function 無効な形式の場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['unexpected_key' => 'unexpected_value']);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '無効な形式のデータが成功を返しました。');
    }

    #[Test]
    public function 有効なラインストリングの場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['type' => 'LineString', 'coordinates' => [[-100.0, 45.0], [-101.0, 46.0]]]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertTrue($actual, '有効なLineStringデータが失敗を返しました。');
    }

    #[Test]
    public function ラインストリングの座標が不足している場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode(['type' => 'LineString', 'coordinates' => [[-100.0, 45.0]]]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '座標が不足しているLineStringデータが成功を返しました。');
    }

    #[Test]
    public function ポリゴンが有効な場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode([
            'type' => 'Polygon',
            'coordinates' => [[[-100.0, 45.0], [-101.0, 45.0], [-101.0, 46.0], [-100.0, 45.0]]]
        ]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertTrue($actual, '有効なPolygonデータが失敗を返しました。');
    }

    #[Test]
    public function ポリゴンの座標が閉じていない場合(): void
    {
        $instance = new GeoJsonRule();
        $parameters = $this->createParameter([]);
        $value = json_encode([
            'type' => 'Polygon',
            'coordinates' => [[[-100.0, 45.0], [-101.0, 45.0], [-101.0, 46.0]]]
        ]);

        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '閉じていないPolygonデータが成功を返しました。');
    }
}