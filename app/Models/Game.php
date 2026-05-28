<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    /**
     * Relationships
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
