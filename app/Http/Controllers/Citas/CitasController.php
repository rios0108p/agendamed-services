<?php

namespace App\Http\Controllers\Pacientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;
use Illuminate\Support\Facades\DB;

class CitasController extends Controller
{
    public function getUsuarios() {

        $dataUsuario = DB::table('informacion_usuario')
        ->select('id_info_usuario', 'nombre', 'apellido_m', 'apellido_p', 'fecha_nacimiento')
        ->get();

        if ($dataUsuario) {
            $json = array(
                'status'=>200,
                'data'=>$dataUsuario
            );

        } else {
            $json = array(
                'status'=>404,
                'message'=>'No hay registros'
            );
        }

        return json_encode($json, true);
    }

    public function guardarCita(Request $request) {
        $datauser = array("id_usuario"=>$request->input("id_usuario"),
                          "fecha_cita"=>$request->input("fecha_cita"),
                          "comentarios"=>$request->input("comentarios"),
                          "decripcion_cita"=>$request->input("decripcion_cita"));

        $citaData = new Citas();
        $citaData->id_usuario = $datauser["id_usuario"];;
        $citaData->id_medico = 1;
        $citaData->comentarios = $datauser["comentarios"];
        $citaData->decripcion_cita = $datauser["decripcion_cita"];
        $citaData->fecha_cita = $datauser["fecha_cita"];

        $citaData->save();

        $json = array(
            'status'=>200,
            'message'=>'Cita registrada correctamente'
        );

        return json_encode($json, true);
    }

    public function borrarPaciente(Request $id) {
        $datauser = array("id_usuario"=>$id->input("id_usuario"));
        $borrarPaciente = DB::table('informacion_usuario')
        ->where('id_info_usuario', '=', $datauser['id_usuario']) 
        ->delete();

    

        $json = array(
            'status'=>200,
            'data'=> $borrarPaciente,
            'id' => $id,
            'message'=>'Paciente borrado correctamente'
        );

        return json_encode($json, true);
    }

}
