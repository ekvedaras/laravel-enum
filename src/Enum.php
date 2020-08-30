<?php

namespace EKvedaras\LaravelEnum;

use EKvedaras\PHPEnum\Illuminate\Collection\Enum as BaseEnum;
use Illuminate\Contracts\Database\Eloquent\Castable;

/**
 * Class Enum
 * @package EKvedaras\LaravelEnum
 */
class Enum extends BaseEnum implements Castable
{
    /**
     * @inheritDoc
     */
    public static function castUsing()
    {
        return EnumCaster::class;
    }
}
