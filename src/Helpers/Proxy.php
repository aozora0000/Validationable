<?php

namespace Validationable\Helpers;

final class Proxy
{
    public mixed $target;

    public static function tap($value, $callback = null)
    {
        if (is_null($callback)) {
            return new self($value);
        }

        $callback($value);

        return $value;
    }

    /**
     * Create a new tap proxy instance.
     *
     * @param  mixed  $target
     */
    public function __construct(mixed $target)
    {
        $this->target = $target;
    }

    /**
     * Dynamically pass method calls to the target.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        $this->target->{$method}(...$parameters);

        return $this->target;
    }
}