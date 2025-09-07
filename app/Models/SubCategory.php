<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

     protected $table = 'subcategories';

    protected $fillable = ['category_id', 'name', 'description'];

    // A subcategory belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
    
}