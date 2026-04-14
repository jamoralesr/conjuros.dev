<?php

namespace App\Models;

use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /** @use HasFactory<PlanFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price_monthly',
        'price_yearly',
        'stripe_price_id_monthly',
        'stripe_price_id_yearly',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
    ];

    public function stripePriceIdFor(string $interval): ?string
    {
        return match ($interval) {
            'monthly' => $this->stripe_price_id_monthly,
            'yearly' => $this->stripe_price_id_yearly,
            default => null,
        };
    }
}
