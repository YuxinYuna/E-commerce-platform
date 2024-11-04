<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Define relationship with User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
