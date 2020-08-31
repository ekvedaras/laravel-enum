# Laravel Enum

This package integrates [ekvedaras/php-enum](https://github.com/ekvedaras/php-enum)
into Laravel by providing [enum value casting in models](https://laravel.com/docs/7.x/eloquent-mutators#custom-casts) which was introduced in Laravel 7.

## Usage

**PaymentStatus.php**
```php
use EKvedaras\LaravelEnum\Enum;

class PaymentStatus extends Enum
{
    /**
     * @return static
     */
    final public static function pending(): self
    {
        return static::get('pending', 'Payment is pending');
    }

    /**
     * @return static
     */
    final public static function completed(): self
    {
        return static::get('completed', 'Payment has been processed');
    }

    /**
     * @return static
     */
    final public static function failed(): self
    {
        return static::get('failed', 'Payment has failed');
    }
}
```

### Casting

**Payment.php**
```php
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = [
        'status' => PaymentStatus::class,
    ];
}
```

Setting and retrieving status:
```php
$payment = new Payment();

// It is advised to always set enum objects instead of strings for better usage analysis
$payment->status = PaymentStatus::pending();
// However, above works the same as this
$payment->status = 'pending';
// or this
$payment->status = PaymentStatus::pending()->id();

dump($payment->status === PaymentStatus::pending()); // true

$payment->status = 'invalid'; // throws OutOfBoundsException
```

### Validation

A built in `in` validator can be used.

```php
use Illuminate\Validation\Rule;

$rules = [
    'status' => Rule::in(PaymentStatus::keys())
];

// or

$rules = [
    'status' => 'in:' . PaymentStatus::keyString(),
];
```
