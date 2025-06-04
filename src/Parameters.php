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
use Validationable\Rules\ObjectRule;
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
        'object' => ObjectRule::class,
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
            default => throw new \Exception('Invalid params'),
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

    public function passes(): bool
    {
        $result = true;
        $this->prepareValidate();
        foreach($this->rules() as $attribute => $rules) {
            $validations = [];
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
                $validations[] = match(true) {
                    Str::isClassString($rule, RuleInterface::class) => ['rule' => new $rule, 'arguments' => $arguments],
                    is_a($rule, RuleInterface::class) => ['rule' => $rule, 'arguments' => $arguments],
                    default => throw new \Exception('Invalid rule'),
                };
            }
            foreach($validations as $validation) {
                if($validation['rule'] instanceof SometimesRule && !$validation['rule']->passes($attribute, $this, $validation['arguments'])) {
                    continue 2; // sometimesがfalseの場合は後ろを処理しない
                }
                if(!$validation['rule']->passes($attribute, $this, $validation['arguments'])) {
                    $this->errors[$attribute] = sprintf("%s is invalid: %s", $attribute, class_basename($validation['rule']));
                    $result = false;
                }
            }
        }
        $this->afterValidate();
        return $result;
    }

    public function errors(): array
    {
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