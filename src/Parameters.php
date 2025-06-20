<?php

namespace Validationable;


use AllowDynamicProperties;
use ArrayAccess;
use Validationable\Helpers\Arr;
use Validationable\Helpers\RuleArgumentParser;
use Validationable\Helpers\Str;
use Validationable\Rules\ActiveUrlRule;
use Validationable\Rules\AlphaDashRule;
use Validationable\Rules\AlphaNumRule;
use Validationable\Rules\AlphaRule;
use Validationable\Rules\ArrayKeysRule;
use Validationable\Rules\ArrayRule;
use Validationable\Rules\BetweenRule;
use Validationable\Rules\BooleanRule;
use Validationable\Rules\CallableRule;
use Validationable\Rules\ClassMethodStringRule;
use Validationable\Rules\ClassStringRule;
use Validationable\Rules\ClosureRule;
use Validationable\Rules\ConstructableRule;
use Validationable\Rules\CountableRule;
use Validationable\Rules\DateFormatRule;
use Validationable\Rules\DateRule;
use Validationable\Rules\DatetimeRule;
use Validationable\Rules\DistinctRule;
use Validationable\Rules\EmailRule;
use Validationable\Rules\EndsWithRule;
use Validationable\Rules\EqualsRule;
use Validationable\Rules\FileMtime;
use Validationable\Rules\FileRule;
use Validationable\Rules\ImageHeightRule;
use Validationable\Rules\ImageRatioRule;
use Validationable\Rules\ImageRule;
use Validationable\Rules\ImageWidthRule;
use Validationable\Rules\InRule;
use Validationable\Rules\InstanceOfRule;
use Validationable\Rules\IntegerRule;
use Validationable\Rules\IpRule;
use Validationable\Rules\Ipv4Rule;
use Validationable\Rules\Ipv6Rule;
use Validationable\Rules\LengthRule;
use Validationable\Rules\LessThanEqualRule;
use Validationable\Rules\LessThanRule;
use Validationable\Rules\MimesRule;
use Validationable\Rules\MissingRule;
use Validationable\Rules\MoreThanEqualRule;
use Validationable\Rules\MoreThanRule;
use Validationable\Rules\NotInRule;
use Validationable\Rules\NumericRule;
use Validationable\Rules\RegexPatternRule;
use Validationable\Rules\RequiredIfRule;
use Validationable\Rules\RequiredRule;
use Validationable\Rules\SameRule;
use Validationable\Rules\SizeRule;
use Validationable\Rules\SometimesRule;
use Validationable\Rules\StartsWithRule;
use Validationable\Rules\StringRule;
use Validationable\Rules\TimeZoneRule;
use Validationable\Rules\UniqueRule;
use Validationable\Rules\UrlRule;

/**
 * @template T
 */
#[AllowDynamicProperties] abstract class Parameters implements ArrayAccess
{
    /**
     * @var array<string, class-string>
     */
    public static array $rules = [
        // HasValue
        'sometimes' => SometimesRule::class,
        'required' => RequiredRule::class,
        'required_if' => RequiredIfRule::class,
        'same' => SameRule::class,
        'missing' => MissingRule::class,
        'equals' => EqualsRule::class,
        // Primitive
        'in' => InRule::class,
        'not_in' => NotInRule::class,
        'boolean' => BooleanRule::class,
        'integer' => IntegerRule::class,
        'between' => BetweenRule::class,
        'more_than' => MoreThanRule::class,
        'more_than_equal' => MoreThanEqualRule::class,
        'mt' => MoreThanRule::class,
        'mte' => MoreThanEqualRule::class,
        'less_than' => LessThanRule::class,
        'less_than_equal' => LessThanEqualRule::class,
        'lt' => LessThanRule::class,
        'lte' => LessThanEqualRule::class,
        'numeric' => NumericRule::class,
        'string' => StringRule::class,
        'regex_pattern' => RegexPatternRule::class,
        'alpha' => AlphaRule::class,
        'alpha_dash' => AlphaDashRule::class,
        'alpha_num' => AlphaNumRule::class,
        'starts_with' => StartsWithRule::class,
        'ends_with' => EndsWithRule::class,
        'email' => EmailRule::class,
        'url' => UrlRule::class,
        'active_url' => ActiveUrlRule::class,
        'ip' => IpRule::class,
        'ipv4' => IpV4Rule::class,
        'ipv6' => Ipv6Rule::class,
        'class-string' => ClassStringRule::class,
        'class-method-string' => ClassMethodStringRule::class,
        // Object
        'closure' => ClosureRule::class,
        'instance_of' => InstanceOfRule::class,
        'constructable' => ConstructableRule::class,
        'callable' => CallableRule::class,
        // Array
        'array' => ArrayRule::class,
        'countable' => CountableRule::class,
        'unique' => UniqueRule::class,
        'distinct' => DistinctRule::class,
        'length' => LengthRule::class,
        'array_keys' => ArrayKeysRule::class,
        // Date/DateTime
        'date' => DateRule::class,
        'date_format' => DateFormatRule::class,
        'date_time' => DatetimeRule::class,
        'timezone' => TimeZoneRule::class,
        // File/Image
        'file' => FileRule::class,
        'mtime' => FileMtime::class,
        'size' => SizeRule::class,
        'mime' => MimesRule::class,
        'image' => ImageRule::class,
        'image_height' => ImageHeightRule::class,
        'image_width' => ImageWidthRule::class,
        'image_ratio' => ImageRatioRule::class,
    ];

    protected array $params = [];

    protected array $errors = [];

    protected bool $validated = false;

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

    public function macros(): array
    {
        return static::$rules;
    }

    public function validate($rule, string $attribute, mixed $value, array $arguments = []): bool
    {
        $parser = new RuleArgumentParser(static::$rules);
        [$rule, $arguments] = $parser->parse($rule);

        $check = fn($val) => $rule->passes($attribute, $val, $this, $arguments);
        return Str::isGlob($attribute) ? Arr::every($value, $check) : $check($value);
    }

    public function passes(): bool
    {
        if ($this->validated) {
            return $this->errors === [];
        }

        $this->prepareValidate();

        foreach ($this->rules() as $attribute => $rules) {
            foreach (Arr::toArray($rules) as $rule) {
                $result = $this->validate($rule, $attribute, Arr::get($this->toArray(), $attribute));
                if ($result) {
                    continue;
                }

                if ($rule === 'sometimes' || $rule instanceof SometimesRule) {
                    continue 2; // sometimesがfalseの場合は後ろを処理しない
                }

                $ruleString = Str::of($rule) ? $rule : get_class($rule);
                $name = Arr::findByValue(static::$rules, $ruleString, $ruleString);
                $this->errors[$attribute][$name] = sprintf("%s is invalid: %s", $attribute, $name);
            }
        }

        $this->afterValidate();
        $this->validated = true;
        return $this->errors === [];
    }

    protected function prepareValidate(): void
    {

    }

    abstract public function rules(): array;

    public function get(string $key, $default = null)
    {
        return Arr::get($this->toArray(), $key, $default);
    }

    protected function afterValidate(): void
    {

    }

    public function errors(): array
    {
        if (!$this->validated) {
            $this->passes();
        }

        return $this->errors;
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->toArray(), $offset);
    }

    public function has(string $key): bool
    {
        return Arr::has($this->toArray(), $key);
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
}