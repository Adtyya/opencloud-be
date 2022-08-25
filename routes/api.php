<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeController;
use App\Http\Resources\RowResource;
use App\Http\Resources\RowEmployerResource;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("register", [AuthController::class, ('register')]);
Route::post("login", [AuthController::class, ("login")])->middleware("web");

Route::get("test", function(){
    return response()->json([
        "asdlkjasd" => "Helo"
    ]);
});

Route::group([
    "middleware" => ["auth:sanctum"],
    "prefix" => "user"
], function(){
    Route::get("me", [AuthController::class, ("me")]);
    Route::post('logout', [AuthController::class, ("logout")]);
});

Route::group([
    "middleware" => ["auth:sanctum", "admin"],
    "prefix" => "admin"
], function(){
    Route::get("test", function(){
        return response()->json([
            "msg" => "success"
        ]);
    });
    Route::get("row/company", function(){
        return response()->json([
            "row_name" => ["Nama Perusahaan", "Website", "Logo"]
        ]);
    });
    Route::get("company", [CompanyController::class, ("index")]);
    Route::post("company", [CompanyController::class, ("store")]);
    Route::put("company/{company}", [CompanyController::class, ("update")]);
    Route::get("company/{company}", [CompanyController::class, ("show")]);
    Route::delete("company/d/{company}", [CompanyController::class, ('destroy')]);

    Route::get("row/employer", function(){
        return response()->json([
            "row_name" => ["First name", "Last name","email", "Phone", "Company"]
        ]);
    });
    Route::get("employe", [EmployeController::class, ("index")]);
    Route::get("employe/{employe}", [EmployeController::class, ('show')]);
    Route::delete("employe/{employe}", [EmployeController::class, ("destroy")]);
    Route::post("employe", [EmployeController::class, ("store")]);
    Route::put("employe/{employe}", [EmployeController::class, ("update")]);
});