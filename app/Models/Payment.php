<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'institute_id', 'student_id', 'retailer_id', 'amount', 'type', 'status', 'payment_type'
    ];

    public function retailer()
    {
        return $this->belongsTo('App\Models\Retailer');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function institute()
    {
        return $this->belongsTo('App\Models\Institute');
    }
}
