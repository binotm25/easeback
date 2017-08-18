<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstituteController extends Controller
{
    private $Institute;

    public function __construct(Institute $institute)
    {
        $this->Institute = $institute;
    }

    public function getInstitutes(Request $request)
    {
        //dd($request->all());
        $search = $this->Institute->select('id', 'client_id', 'name', 'address', 'mobile')->where('type', $request->searchType)->search($request->q, null, true, false)
            ->with('client')
            ->get();

//        DB::listen(function($sql) {
//            dd($sql);
//        });

        return response()->json([
            'search'    =>  $search
        ]);
    }
}
