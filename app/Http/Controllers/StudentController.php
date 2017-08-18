<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Retailer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    private $Student, $Retailer, $Payment;

    public function __construct(Student $student, Retailer $retailer, Payment $payment)
    {
        $this->Student  =   $student;
        $this->Retailer =   $retailer;
        $this->Payment  =   $payment;

    }

    public function getStudent(Request $request)
    {
        //dd($request->all());
        $search = $this->Student->select('id', 'institute_id', 'name', 'reg_id', 'father_name', 'class', 'section', 'roll_no')->where('institute_id', $request->instituteId)->search($request->studentReg, null, true, false)
            ->get();

        return response()->json([
            'search'    =>  $search
        ]);
    }

    public function payment(Request $request)
    {
        $type       =   $request->type;
        $amount     =   $request->amount;
        $studentId  =   $request->studentId;

        $retailer = $this->Retailer->where('user_id', Auth::user()->id)->first();
        if($retailer->balance > $amount){

            $student = $this->Student->find($studentId);

            if(isset($student)){

                $this->Payment->create([
                    'institute_id'      =>  $student->institute_id,
                    'student_id'        =>  $student->id,
                    'retailer_id'       =>  $retailer->id,
                    'amount'            =>  $amount,
                    'type'              =>  $type,
                    'status'            =>  1,
                    'payment_type'      =>  1,
                ]);

                $retailer->balance = $retailer->balance - $amount;
                $retailer->save();

                return response()->json([
                    'status'        =>  'Success',
                    'title'         =>  'Done!',
                    'message'       =>  'You have successfully paid a fee for the Student '. $student->name,
                    'link'          =>  'Please click here to download the receipt!'
                ]);
            }

        }else{
            return response()->json([
                'status'    =>  'Failed',
                'title'     =>  'Oops!',
                'message'   =>  'We are unable to process your request!'
            ], 401);
        }
    }
}
