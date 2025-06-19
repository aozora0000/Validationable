<?php

namespace Tests\Unit;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function createParameter(array $values, array $rules = []): Parameters
    {
        $mock = $this->createMock(Parameters::class);
        $mock->method('rules')->willReturn($rules);
        $mock->method('toArray')->willReturn($values);
        $mock->method('all')->willReturn($values);
        return $mock;
    }

    public function createDummyRule(bool $passed = true): RuleInterface
    {
        $mock = $this->createMock(RuleInterface::class);
        $mock->method('passes')->willReturn($passed);
        return $mock;
    }
}