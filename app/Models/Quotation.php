<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    protected $guarded = [];

    // users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // quotation details
    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetail::class, 'quotation_id');
    }

}
