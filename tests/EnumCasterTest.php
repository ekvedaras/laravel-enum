<?php

namespace Tests;

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * Class EnumCasterTest
 * @package Tests
 */
class EnumCasterTest extends TestCase
{
    /** @test */
    public function it_casts_enum_attributes()
    {
        $payment = new Payment();

        $this->assertNull($payment->status);

        // It can set null
        $payment->status = null;
        $this->assertNull($payment->status);

        // Sets value as object
        $payment->status = PaymentStatus::completed();

        $this->assertEquals(PaymentStatus::completed()->id(), $payment->getRawAttributes()['status']);
        $this->assertSame(PaymentStatus::completed(), $payment->status);

        // Sets value as string
        $payment->status = PaymentStatus::failed()->id();
        $this->assertEquals(PaymentStatus::failed()->id(), $payment->getRawAttributes()['status']);
        $this->assertSame(PaymentStatus::failed(), $payment->status);
    }

    /** @test */
    public function it_prevents_invalid_values()
    {
        $payment      = new Payment();
        $invalidValue = 'invalid';

        $this->expectExceptionObject(
            new OutOfBoundsException(PaymentStatus::class . "::from({$invalidValue}): given id doesn't exist on this enumerable type.")
        );

        $payment->status = $invalidValue;
    }

    /** @test */
    public function it_does_not_allow_to_set_same_value_from_other_enum_class()
    {
        $payment = new Payment();

        $this->expectExceptionObject(
            new InvalidArgumentException('The given value is not an instance of ' . PaymentStatus::class . '.')
        );

        $payment->status = UserStatus::pending();
    }
}
