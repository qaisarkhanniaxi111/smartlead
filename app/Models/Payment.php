<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const UNPAID = 0;
    public const PAID = 1;

    protected $fillable = ['user_id', 'payment_id', 'amount', 'currency', 'status'];

    public function scopePaid(Builder $builder)
    {
        $builder->where('status', Payment::PAID);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (int $value) => $value * 100,
        );
    }

}
