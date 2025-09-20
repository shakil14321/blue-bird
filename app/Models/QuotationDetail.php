<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $guarded = [];

    // quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    // subcategory
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategories_id');
    }
}
