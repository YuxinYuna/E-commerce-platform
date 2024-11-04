<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'price', 'stock', 'image'];

    /**
     * Define relationship with CartItem model.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Define relationship with Order model through order_products table.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }
}