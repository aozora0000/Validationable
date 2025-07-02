<?php

namespace Validationable;

use BackedEnum;
use UnitEnum;
use Validationable\Contracts\EnumRuleInterface;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;

class Rule
{
    public static function callback(callable $callback): RuleInterface
    {
        return new class($callback) implements RuleInterface {
            public function __construct(private $callback)
            {
            }

            public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
            {
                return ($this->callback)($attribute, $value, $parameters, $arguments);
            }
        };
    }

    public static function when(array $rules, array $onSuccess = [], array $onFailure = []): RuleInterface
    {
        return new readonly class($rules, $onSuccess, $onFailure) implements RuleInterface {
            public function __construct(
                private array $rules,
                private array $onSuccess,
                private array $onFailure
            )
            {
            }

            public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
            {
                $condition = fn($rule): bool => $parameters->validate($rule, $attribute, $value, $arguments);
                if (Arr::every($this->rules, $condition)) {
                    return Arr::every($this->onSuccess, $condition);
                }

                return Arr::every($this->onFailure, $condition);
            }
        };
    }

    public static function enum(string $enum): EnumRuleInterface
    {
        /**
         * @template T of UnitEnum | BackedEnum
         */
        return new class($enum) implements EnumRuleInterface {
            protected string $enum;

            protected array $expects = [];

            /**
             * @property class-string $enum
             */
            public function __construct(string $enum)
            {
                if (!is_a($enum, UnitEnum::class, true)) {
                    throw new \InvalidArgumentException('The enum must be an instance of Enum');
                }

                $this->enum = $enum;
            }

            /**
             * @param UnitEnum $expects
             */
            public function expect(array $expects): EnumRuleInterface
            {
                foreach ($expects as $expect) {
                    if (!is_a($expect, $this->enum, false)) {
                        throw new \InvalidArgumentException('The enum must be an instance of Enum');
                    }

                    $this->expects[] = $expect;
                }

                return $this;
            }

            public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
            {
                foreach ($this->enum::cases() as $case) {
                    if (in_array($case, $this->expects, true)) {
                        continue;
                    }

                    $property = match (true) {
                        is_a($case, BackedEnum::class, false) => 'value',
                        is_a($case, UnitEnum::class, false) => 'name',
                        default => null,
                    };
                    if ($property === null) {
                        continue;
                    }

                    if ($case === $value || $case->{$property} === $value) {
                        return true;
                    }
                }

                return false;
            }
        };
    }
}