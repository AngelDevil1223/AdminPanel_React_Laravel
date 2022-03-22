<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('register' , [AuthUserController::class , 'create']);

// // freelancer / Adimm login
// Route::post('login' , [AuthUserController::class , 'login']);

//  freelancer get him avatar from leaderboard
Route::get('cars', [Controller::class ,'getAllcars']);

Route::post('car', [Controller::class , 'addCar']);

// 
Route::get('requests',[Controller::class, 'getRequests']);

Route::post('request' , [Controller::class, 'postRequest']);

Route::post('userpermission', [Controller::class, 'userPermission']);

// add vehicle
Route::post('vehicle', [Controller::class , 'addVehicle']);

//get all vehicle
Route::get('vehicles' , [Controller::class, 'getAllVehicles']);

// post rental
Route::post('rentle', [Controller::class, 'addRentle']);

//get all rental
Route::get('rentles', [Controller::class, 'getRentels']);

//  post update current location
Route::post('updatelocation', [Controller::class, 'postLocation']);

// get all update location
Route::get('updatelocations', [Controller::class, 'getUpdatelocations']);