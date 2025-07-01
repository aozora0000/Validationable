<?php

namespace Validationable\Contracts;

use BackedEnum;
use UnitEnum;

/**
 * @template T of UnitEnum | BackedEnum
 */
interface EnumRuleInterface extends RuleInterface
{
    /**
     * @param UnitEnum[] | BackedEnum[] $expects
     */
    public function expect(array $expects): self;
}