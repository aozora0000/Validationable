<?php

namespace Validationable;


use ArrayAccess;
use Validationable\Rules\ArrayRule;
use Validationable\Rules\BetweenRule;
use Validationable\Rules\BooleanRule;
use Validationable\Rules\ClassMethodString;
use Validationable\Rules\ClassStringRule;
use Validationable\Rules\ClosureRule;
use Validationable\Rules\InRule;
use Validationable\Rules\IntegerRule;
use Validationable\Rules\LengthRule;
use Validationable\Rules\LessRule;
use Validationable\Rules\LessThanEqualRule;
use Validationable\Rules\MoreRule;
use Validationable\Rules\MoreThanEqualRule;
use Validationable\Rules\NotInRule;
use Validationable\Rules\NumericRule;
use Validationable\Rules\InstanceOfRule;
use Validationable\Rules\RequiredIfRule;
use Validationable\Rules\RequiredRule;
use Validationable\Rules\RuleInterface;
use Validationable\Rules\SometimesRule;
use Validationable\Rules\StringRule;

/**
 * @template T
 */
abstract class Parameters implements ArrayAccess
{
    /**
     * @var array
     */
    protected array $params = [];
    protected array $errors = [];
    protected bool $validated = false;

    protected array $rules = [
        'sometimes' => SometimesRule::class,
        'required' => RequiredRule::class,
        'required_if' => RequiredIfRule::class,
        'in' => InRule::class,
        'not_in' => NotInRule::class,
        'boolean' => BooleanRule::class,
        'integer' => IntegerRule::class,
        'between' => BetweenRule::class,
        'more' => MoreRule::class,
        'more_than_equal' => MoreThanEqualRule::class,
        'mte' => MoreThanEqualRule::class,
        'less' => LessRule::class,
        'less_than_equal' => LessThanEqualRule::class,
        'lte' => LessThanEqualRule::class,
        'numeric' => NumericRule::class,
        'string' => StringRule::class,
        'class-string' => ClassStringRule::class,
        'class-method-string' => ClassMethodString::class,
        'closure' => ClosureRule::class,
        'instance_of' => InstanceOfRule::class,
        'array' => ArrayRule::class,
        'length' => LengthRule::class,
    ];


    /**
     * @param T $params
     */
    public function __construct($params)
    {
        $this->params = match (true) {
            Arr::of($params) => Arr::toArray($params),
            default => throw new \InvalidArgumentException('Invalid params'),
        };
    }

    /**
     * @return T
     */
    public function toArray(): array
    {
        return $this->params;
    }

    /**
     * @return T
     */
    public function all(): array
    {
        return $this->toArray();
    }

    public function rules(): array
    {
        return [];
    }

    public function valid(): bool
    {

    }

    public function passes(): bool
    {
        if($this->validated) {
            return empty($this->errors);
        }
        $this->prepareValidate();

        foreach($this->rules() as $attribute => $rules) {
            foreach($rules as $rule) {
                $arguments = [];
                // 引数がある場合はここで初期化する
                if(is_string($rule) && str_contains( $rule, ":")) {
                    [$rule, $arguments] = explode(":", $rule);
                    $arguments = explode(",", $arguments);
                }
                if(is_string($rule) && array_key_exists($rule, $this->rules)) {
                    $rule = $this->rules[$rule];
                }
                $rule = match(true) {
                    Str::isClassString($rule, RuleInterface::class) => new $rule,
                    is_a($rule, RuleInterface::class) => $rule,
                    default => throw new \Exception('Invalid rule'),
                };
                $value = Arr::get($this->toArray(), $attribute);
                $check = fn($val) => $rule->passes($attribute, $val, $this, $arguments);
                $failed = Str::isGlob($attribute) ? !Arr::every($value, $check) : !$check($value);
                if($failed && $rule instanceof SometimesRule) {
                    continue 2; // sometimesがfalseの場合は後ろを処理しない
                }
                if($failed) {
                    $name = Arr::findByValue($this->rules, get_class($rule), get_class($rule));
                    $this->errors[$attribute][$name] = sprintf("%s is invalid: %s", $attribute, $name);
                }
            }
        }
        $this->afterValidate();
        $this->validated = true;
        return empty($this->errors);
    }

    public function errors(): array
    {
        if(!$this->validated) {
            $this->passes();
        }
        return $this->errors;
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->toArray(), $offset);
    }

    public function offsetGet($offset): mixed
    {
        return Arr::get($this->toArray(), $offset);
    }

    public function offsetSet($offset, $value): void
    {
        Arr::set($this->params, $offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        Arr::forget($this->params, $offset);
    }

    protected function prepareValidate(): void
    {

    }

    protected function afterValidate(): void
    {

    }
}