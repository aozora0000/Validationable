<?php

namespace Unit\Validationable;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Arr;

class ArrTest extends TestCase
{
    public static function getProvider(): array
    {
        return [
            ['test', 'test', null],
            ['test2', 'invalidKey', 'test2'],
            ['test3', 'test2.test3', null],
            ['test4', 'test2.1', null],
            [['test5'], 'test5.*.ttt', null],
        ];
    }
    #[Test]
    #[DataProvider('getProvider')]
    public function testGet(mixed $expected, string $key, mixed $default): void
    {
        $arr = [
            'test' => 'test',
            'test2' => [
                'test3' => 'test3',
                1 => 'test4',
            ],
            'test5' => [
                [
                    'ttt' => 'test5'
                ]
            ],
        ];
        $this->assertSame($expected, Arr::get($arr, $key, $default));
    }
}