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


// Rutas para Pacientes y usuarios 
Route::post('registerUser', [\App\Http\Controllers\Pacientes\PatientsController::class, 'saveUser']);
Route::post('crearCuenta', [\App\Http\Controllers\Pacientes\PatientsController::class, 'crearCuenta']);
Route::post('registerPatient', [\App\Http\Controllers\Pacientes\PatientsController::class, 'guardarPacientes']);
Route::get('patientsList', [\App\Http\Controllers\Pacientes\PatientsController::class, 'getPatients']);
Route::post('borrarPaciente', [\App\Http\Controllers\Pacientes\PatientsController::class, 'borrarPaciente']);
Route::get('buscarPaciente', [\App\Http\Controllers\Pacientes\PatientsController::class, 'buscarPaciente']);
Route::get('buscarUsuario', [\App\Http\Controllers\Pacientes\PatientsController::class, 'buscarUsuario']);
Route::get('usersList', [\App\Http\Controllers\Pacientes\PatientsController::class, 'getUsuarios']);
Route::post('registerCita', [\App\Http\Controllers\Pacientes\PatientsController::class, 'guardarCita']);
Route::get('citasList', [\App\Http\Controllers\Pacientes\PatientsController::class, 'getCitas']);
