<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // A category has many subcategories
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

   public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
    
}