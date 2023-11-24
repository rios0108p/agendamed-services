<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





// Route::group(['middleware' => ['cors']], function () {
//     // Rutas para Auth

// });

Route::post('registerUser', [\App\Http\Controllers\Login\LoginController::class, 'saveUser']);
Route::post('login', [\App\Http\Controllers\Login\LoginController::class, 'login']);


// Rutas para Pacientes
Route::post('registerPatient', [\App\Http\Controllers\Pacientes\PatientsController::class, 'savePatients']);
Route::get('patientsList', [\App\Http\Controllers\Pacientes\PatientsController::class, 'getPatients']);
