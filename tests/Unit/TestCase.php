<?php

namespace Tests\Unit;

use Validationable\Parameters;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function createParameter(array $values, array $rules = []): Parameters
    {
        $mock = $this->createMock(Parameters::class);
        $mock->method('rules')->willReturn($rules);
        $mock->method('toArray')->willReturn($values);
        return $mock;
    }
}