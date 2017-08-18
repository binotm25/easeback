<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api', 'isVerified')->get('/user', function (Request $request) {

    if($request->user()->verified != 1){
        return response()->json([
            'message'   =>  'The user is not verified yet! Please check your mail for verification details!',
            'error'     =>  'Not Verified!'
        ], 401);
    }

    return $request->user();

});

Route::post('/activate/email/{email}', ['uses'=>'AuthCon\AuthController@authenticateEmail']);
Route::post('/register', ['uses'=>'AuthCon\AuthController@postRegister']);

Route::post('/login', function(Request $request){
    return $request->all();
});

Route::group(['middleware'=>['auth:api', 'isVerified']], function(){

    Route::post('/getBanks', ['uses'=>'BankController@getBanks']);


    Route::prefix('manage')->group(function(){

        Route::group(['middleware' => ['admin']], function(){
            Route::post('/addDistributor', ['uses'=>'DistributorController@add']);
            Route::get('/distributor/total', ['uses'=>'DistributorController@getTotal']);
            Route::get('/getDistributor/{id}', ['uses'=>'DistributorController@getSingleDistributor']);
        });

        Route::group(['middleware'=>['client']], function(){
            Route::post('/addClient', ['uses'=>'ClientController@add']);
            Route::get('/client/total', ['uses'=>'ClientController@getTotal']);
            Route::get('/getClient/{id}', ['uses'=>'ClientController@getSingleClient']);
        });

        Route::group(['middleware'=>['distributor']], function() {
            Route::post('/addRetailer', ['uses' => 'RetailerController@add']);
            Route::get('/retailer/total', ['uses' => 'RetailerController@getTotal']);
            Route::get('/getRetailer/{id}', ['uses' => 'RetailerController@getSingleClient']);
        });
    });

    Route::group(['middleware'=>['retailer']], function() {
        Route::get('/search/institute', ['uses' => 'InstituteController@getInstitutes']);
        Route::get('/search/student', ['uses' => 'StudentController@getStudent']);

        Route::get('/retailer/getRetailer', ['uses'=>'RetailerController@getRetailer']);
    });

    Route::prefix('student')->group(function(){

        Route::post('payment', ['uses'=>'StudentController@payment']);

    });


});