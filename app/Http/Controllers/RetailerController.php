<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDistributor;
use App\Mail\ActivationMail;
use App\Models\Retailer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use UserVerification;

class RetailerController extends Controller
{
    private $Retailer, $User, $Auth;

    public function __construct(Retailer $retailer, User $user)
    {
        $this->Retailer     =   $retailer;
        $this->User         =   $user;
        $this->Auth         =   Auth::user();
    }

    public function add(AddDistributor $request)
    {
        $add = $this->addEditRetailer($request, 'add');

        if($add[0] == 1){
            return response()->json([
                'status'    =>  1,
                'message'   =>  $add[1]
            ]);
        }else{
            return response()->json([
                'status'    =>  0,
                'message'   =>  $add[1]
            ], 401);
        }
    }

    public function getTotal()
    {
        $retailer = $this->Retailer->paginate(100);
        return response()->json([
            'retailers'  =>  $retailer
        ], 200);
    }

    public function getSingleClient($id)
    {
        $single = $this->Retailer->find($id);

        if(isset($single)){
            return response()->json([
                'single'    =>  $single,
                'status'    =>  1
            ]);
        }else{
            return response()->json([
                'message'   =>  'There is no such user',
                'status'    =>  0
            ], 404);
        }
    }

    private function addEditRetailer($request, $type, $id = null)
    {

        $message = NULL;

        DB::beginTransaction();

        try {
            if ($type == "add") {

                $newDistributor = $this->Retailer->create([
                    'username'      =>  $request->username,
                    'email'         =>  $request->email,
                    'mobile'        =>  $request->mobile,
                    'address'       =>  $request->address,
                    'aadhar'        =>  $request->aadhar,
                    'shop_name'     =>  $request->shopName,
                    'gps'           =>  $request->gps,
                    'bank_id'       =>  $request->bankName,
                    'bank_branch'   =>  $request->bankBranch,
                    'account_no'    =>  $request->accountNumber,
                    'created_by'    =>  $this->Auth->id
                ]);

                $user = $this->User->create([
                    'name'          =>  $request->username,
                    'email'         =>  $request->email,
                    'password'      =>  bcrypt($request->password),
                    'type'          =>  1
                ]);

                UserVerification::generate($user);
                $verification = $user->verification_token;

                Mail::to($user->email)->send(new ActivationMail($user, $verification));

            }

            DB::commit();
            $success = 1;
            $message = 'Distributor has been successfully created! A verification mail has been sent to the User! Please check!';
        }catch(\Illuminate\Database\QueryException $e){

            $success = 0;
            DB::rollback();
            $message = ($e->getMessage());
        }

        return [$success, $message];
    }
}
