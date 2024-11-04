<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'order_number',
    ];

    // Define relationship with User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define relationship with Product model through order_products table.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
