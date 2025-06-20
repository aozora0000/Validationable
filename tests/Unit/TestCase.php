<?php

namespace Tests\Unit;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function createParameter(array $values, array $rules = []): Parameters
    {
        return new class($values, $rules) extends Parameters {
            public function __construct(array $values, array $rules = [])
            {
                $this->_rules = $rules;
                parent::__construct($values);
            }

            public function rules(): array
            {
                return $this->_rules;
            }
        };
    }

    public function createDummyRule(bool $passed = true): RuleInterface
    {
        $mock = $this->createMock(RuleInterface::class);
        $mock->method('passes')->willReturn($passed);
        return $mock;
    }
}