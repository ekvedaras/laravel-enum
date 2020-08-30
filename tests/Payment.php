<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package Tests
 * @property PaymentStatus|null status
 */
class Payment extends Model
{
    protected $casts = [
        'status' => PaymentStatus::class
    ];

    public function getRawAttributes()
    {
        return $this->attributes;
    }
}
