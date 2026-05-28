<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'title',
        'price',
        'rank',
        'status', // available, sold
        'images', // JSON array of images
        'description',
        'login_details',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Helper to get first image or fallback
     */
    public function getFirstImageAttribute(): string
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=600';
    }
}
