<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WCCredential extends Model
{
    use HasFactory;

    protected $table = 'woocommerce_credentials';

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => str_repeat("\u{2022}", strlen($value))
        );
    }
}
