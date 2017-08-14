<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDistributor;
use App\Mail\ActivationMail;
use App\Models\Distributor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use UserVerification;

class DistributorController extends Controller
{

    private $Distributor, $User, $Auth;

    public function __construct(Distributor $distributors, User $user)
    {
        $this->Distributor  =   $distributors;
        $this->User         =   $user;
        $this->Auth         =   Auth::user();
    }

    public function add(AddDistributor $request)
    {
        $add = $this->addEditDistributor($request, 'add');

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
        $distributors = $this->Distributor->paginate(100);
        return response()->json([
            'distributors'  =>  $distributors
        ], 200);
    }

    public function getSingleDistributor($id)
    {
        $single = $this->Distributor->find($id);

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

    private function addEditDistributor($request, $type, $id = null)
    {

        $message = NULL;

        DB::beginTransaction();

        try {
            if ($type == "add") {

                $newDistributor = $this->Distributor->create([
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
                    'type'          =>  2
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
