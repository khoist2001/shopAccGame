<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_amount',
        'discount_type', // fixed, percent
        'min_spend',
        'expires_at',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'active' => 'boolean',
            'discount_amount' => 'decimal:2',
            'min_spend' => 'decimal:2',
        ];
    }

    /**
     * Check if coupon is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if coupon is valid for spend amount
     */
    public function isValidForAmount($amount): bool
    {
        if (!$this->active) return false;
        if ($this->isExpired()) return false;
        if ($amount < $this->min_spend) return false;
        return true;
    }

    /**
     * Calculate discount amount based on total
     */
    public function calculateDiscount($totalAmount): float
    {
        if ($this->discount_type === 'percent') {
            $discount = ($totalAmount * $this->discount_amount) / 100;
            return min($discount, $totalAmount);
        }
        
        return min($this->discount_amount, $totalAmount);
    }
}
