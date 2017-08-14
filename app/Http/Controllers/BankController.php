<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{

    private $Bank;

    public function __construct(Bank $bank)
    {
        $this->Banks = $bank;
    }

    public function getBanks()
    {
        $banks = $this->Banks->pluck('name', 'id')->toArray();

        return response()->json([
            'banks'     =>  $banks,
            'status'    =>  1
        ]);
    }
}
