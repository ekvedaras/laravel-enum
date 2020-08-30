<?php

namespace EKvedaras\LaravelEnum;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * Class EnumCaster
 * @package EKvedaras\LaravelEnum
 */
class EnumCaster implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $this->enum($model, $key)::from($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$enum = $this->enum($model, $key)) {
            throw new InvalidArgumentException('The given value is not an instance of ' . Enum::class . '.');
        }

        if ($isObject = is_object($value) && !$value instanceof $enum) {
            throw new InvalidArgumentException("The given value is not an instance of {$enum}.");
        }

        return $isObject ? $value->id() : $enum::from($value)->id();
    }

    /**
     * @param        $model
     * @param string $key
     * @return Enum|string|null
     */
    protected function enum($model, string $key): ?string
    {
        return Arr::get($model->getCasts(), $key);
    }
}
