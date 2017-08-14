<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $table = 'retailers';

    protected $fillable = [
        'username', 'email', 'mobile', 'address', 'aadhar', 'shop_name', 'gps', 'bank_id', 'bank_branch', 'account_no', 'created_by'
    ];

}
