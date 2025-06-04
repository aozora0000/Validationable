<?php

namespace Tests\Functional\Validationable;

use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\Functional\TestCase;
use Validationable\Parameters;

class LaravelCollectionValidationTest extends TestCase
{
    #[Test]
    public function コンストラクタで正常に値を取得出来る(): void
    {
        $collection = new Collection([
            'test' => [
                [
                    'id' => 1,
                ]
            ]
        ]);
        $instance = new class($collection) extends Parameters {
            public function rules(): array
            {
                return [
                    'test.*.id' => ['required', 'integer']
                ];
            }
        };
        $this->assertIsArray($instance->all());
        $this->assertTrue($instance->passes());
    }
}