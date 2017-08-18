<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Student extends Model
{

    use SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'students.reg_id' => 10,
            'students.name' => 10,
        ],
//        'joins' => [
//            'clients' => ['institutes.client_id','clients.id'],
//        ],
    ];

    protected $fillable = [
        'institute_id', 'name', 'reg_id', 'father_name', 'class', 'section', 'roll_no', 'mobile', 'address', 'created_by'
    ];

    protected $hidden = [
        'address'
    ];
}
