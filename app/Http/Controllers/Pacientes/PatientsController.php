<?php

namespace App\Http\Controllers\Pacientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;
use Illuminate\Support\Facades\DB;

class PatientsController extends Controller
{
    public function getPatients(Request $request) {

        $dataPaciente = DB::table('Patients')
        ->select('Firstname', 'Lastname', 'Phone', 'Email')
        ->get();

        if ($dataPaciente) {
            $json = array(
                'status'=>200,
                'data'=>$dataPaciente
            );

        } else {
            $json = array(
                'status'=>404,
                'message'=>'No hay registros'
            );
        }

        return json_encode($json, true);
    }

    public function savePatients(Request $request) {

        $datauser = array("firstName"=>$request->input("firstName"),
                          "lastName"=>$request->input("lastName"),
                          "phone"=>$request->input("phone"),
                          "email"=>$request->input("email"));

        $userData = new Patients();
        $userData->IdPaciente = 'AGM1';
        $userData->Firstname = $datauser["firstName"];
        $userData->Lastname = $datauser["lastName"];
        $userData->Phone = $datauser["phone"];
        $userData->Email = $datauser["email"];

        $userData->save();

        $json = array(
            'status'=>200,
            'message'=>'Paciente registrado correctamente'
        );

        return json_encode($json, true);
    }
}
