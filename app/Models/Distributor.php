<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = [
        'username', 'password', 'email', 'mobile', 'address', 'aadhar', 'shop_name', 'gps', 'bank_id', 'bank_branch', 'account_no', 'created_by'
    ];
}
