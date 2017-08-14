<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'Clients';

    protected $fillable = [
        'username', 'email', 'mobile', 'address', 'aadhar', 'school', 'gps', 'bank_id', 'bank_branch', 'account_no', 'created_by'
    ];
}
