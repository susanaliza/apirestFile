<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\MultipleFileController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|
--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createuser',[UserController::class, 'store']); //create user
Route::post('login',[UserController::class, 'login']); //login user



Route::group(['middleware'=>'auth:api'], function(){

    Route::get('allfiles', [FileController::class, 'index']); //Ver lista de ficheros
    Route::post('uploadfile',[FileController::class,'store']); //Crear un nuevo fichero(Subir un fichero-Limitar el fichero 500kb)
    Route::delete('deletefile/{id}', [FileController::class, 'destroy']);  //Eliminar fichero de forma lógica 
    Route::post('uploadmultiplefile', [MultipleFileController::class, 'uploadFile']); //Subir ficheros de forma masiva

});
    



