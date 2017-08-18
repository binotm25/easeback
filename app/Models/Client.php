<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'username', 'email', 'mobile', 'address', 'aadhar', 'school', 'gps', 'bank_id', 'bank_branch', 'account_no', 'created_by'
    ];

    public function institute()
    {
        return $this->hasMany('App\Models\Institute', 'client_id', 'id');
    }

//    public function bank()
//    {
//        return $this->belongsTo('App\Models\Bank');
//    }
}
