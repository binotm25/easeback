<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use UserVerification;
use App\Mail\ActivationMail;

class ClientController extends Controller
{

    private $Client, $User, $Auth;

    public function __construct(Client $client, User $user)
    {
        $this->Client       =   $client;
        $this->User         =   $user;
        $this->Auth         =   Auth::user();
    }

    public function add(Request $request)
    {
//        return response()->json([
//            'status'    =>  1,
//            'message'   =>  "Client has been successfully created! A verification mail has been sent to the User! Please check!"
//        ]);

        $add = $this->addEditClient($request, 'add');

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
        $clients = $this->Client->paginate(100);
        return response()->json([
            'clients'  =>  $clients
        ], 200);
    }

    public function getSingleClient($id)
    {
        $single = $this->Client->find($id);

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

    private function addEditClient($request, $type, $id = null)
    {

        $message = NULL;

        DB::beginTransaction();

        try {
            if ($type == "add") {

                $newClient = $this->Client->create([
                    'school'        =>  $request->scname,
                    'username'      =>  $request->username,
                    'email'         =>  $request->email,
                    'mobile'        =>  $request->mobile,
                    'address'       =>  $request->address,
                    'aadhar'        =>  $request->aadhar,
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
                    'type'          =>  3
                ]);

                UserVerification::generate($user);
                $verification = $user->verification_token;

                Mail::to($user->email)->send(new ActivationMail($user, $verification));

            }

            DB::commit();
            $success = 1;
            $message = 'Client has been successfully created! A verification mail has been sent to the User! Please check!';
        }catch(\Illuminate\Database\QueryException $e){

            $success = 0;
            DB::rollback();
            $message = ($e->getMessage());
        }

        return [$success, $message];
    }
}
