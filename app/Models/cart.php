<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subcategories_id', 'quantity'];

    // A cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A cart has many items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    // subcategory
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategories_id');
    }
}
