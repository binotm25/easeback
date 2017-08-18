<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Institute extends Model
{
    use SearchableTrait;

    protected $table = "institutes";

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'institutes.type' => 10,
            'institutes.name' => 10,
        ],
//        'joins' => [
//            'clients' => ['institutes.client_id','clients.id'],
//        ],
    ];

    protected $fillable = [
        'client_id', 'type', 'name', 'address', 'mobile'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
