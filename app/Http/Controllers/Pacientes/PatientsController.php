<?php

namespace App\Http\Controllers\Pacientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Citas;
use App\Models\Credenciales;
use Illuminate\Support\Facades\DB;

class PatientsController extends Controller
{
    public function getPatients() {

        $dataPaciente = DB::table('informacion_usuario')
        ->select('id_info_usuario', 'nombre', 'apellido_m', 'apellido_p', 'fecha_nacimiento')
        ->where('id_admin', '=', 3)
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

    //==================================================================================================================================
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

        //==================================================================================================================================

    public function crearCuenta(Request $request) {
        $datauser = array("nombre"=>$request->input("nombre"),
        "apellido_m"=>$request->input("apellido_m"),
        "apellido_p"=>$request->input("apellido_p"),
        "userName"=>$request->input("userName"),
        "password"=>$request->input("password"));

        //Guarda la info en la tabla de informacion_usuario
        $userData = new Patients();
        $userData->id_admin = 2;
        $userData->nombre = $datauser["nombre"];
        $userData->apellido_m = $datauser["apellido_m"];
        $userData->apellido_p = $datauser["apellido_p"];
        $userData->fecha_nacimiento = '';
        $userData->curp ='';
        $userData->genero = '';

        $userData->save();
        //Una vez guardada la info y creado el id_usuario, lo buscamos como el ultimo registro para
        //guardarlo en la tabla de credeciales junto con el usuario y contraseña
        $dataNueva = DB::table('informacion_usuario')
                    ->select('*')
                    ->orderBy('id_info_usuario','desc')
                    ->limit(1)// limita los registros devueltos a 1
                    ->get();
        //decodifica la consulta para poder manejar el array
        $decode = json_decode($dataNueva, true);

        //se manda llamar al modelo Credenciales para guardar
        $userCredenciales = new Credenciales();
        $userCredenciales->id_usuario = $decode[0]['id_info_usuario'];
        $userCredenciales->usuario = $datauser['userName'];
        $userCredenciales->contrasena = $datauser['password'];

        $userCredenciales->save();

        $json = array(
            'status'=>200,
            'message'=>'Cuenta creada correctamente',
            'data'=> $decode[0]['id_info_usuario']
        );

        return json_encode($json, true);

    }

        //==================================================================================================================================

        public function saveUser(Request $request) {
            // Se recuperan los datos del formulario de solicitud y se almacenan en un arreglo asociativo
            $datauser = array(
                "nombre" => $request->input("nombre"),
                "apellido_m" => $request->input("apellido_m"),
                "apellido_p" => $request->input("apellido_p"),
                "fecha_nacimiento" => $request->input("fecha_nacimiento"),
                "curp" => $request->input("curp"),
                "genero" => $request->input("genero"),
                "rol" => $request->input("rol"),
                "usuario" => $request->input("usuario"),
                "contrasena" => $request->input("contrasena")
            );
        
            // Se crea una nueva instancia del modelo Patients (suponemos que representa a un paciente)
            $userData = new Patients();
        
            // Se asignan los valores recuperados del formulario a las propiedades del paciente
            $userData->id_admin = (int) $datauser["rol"]; // Se convierte a entero el rol
            $userData->nombre = $datauser["nombre"];
            $userData->apellido_m = $datauser["apellido_m"];
            $userData->apellido_p = $datauser["apellido_p"];
            $userData->fecha_nacimiento = $datauser["fecha_nacimiento"];
            $userData->curp = $datauser["curp"];
            $userData->genero = $datauser["genero"];
        
            // Se guarda el nuevo registro del paciente en la base de datos
            $userData->save();
        
            // Se crea un arreglo con un mensaje de éxito y un código de estado
            $json = array(
                'status' => 200,
                'message' => 'Paciente registrado correctamente'
            );
        
            // Se devuelve el arreglo $json codificado en formato JSON como respuesta
            return json_encode($json, true);
        }
        

        //==================================================================================================================================

    public function guardarPacientes(Request $request) {
        $datauser = array("nombre"=>$request->input("nombre"),
                          "apellido_m"=>$request->input("apellido_m"),
                          "apellido_p"=>$request->input("apellido_p"),
                          "fecha_nacimiento"=>$request->input("fecha_nacimiento"),
                          "curp"=>$request->input("curp"),
                          "genero"=>$request->input("genero"));

        $userData = new Patients();
        $userData->id_admin = 3;
        $userData->nombre = $datauser["nombre"];
        $userData->apellido_m = $datauser["apellido_m"];
        $userData->apellido_p = $datauser["apellido_p"];
        $userData->fecha_nacimiento = $datauser["fecha_nacimiento"];
        $userData->curp = $datauser["curp"];
        $userData->genero = $datauser["genero"];

        $userData->save();

        $json = array(
            'status'=>200,
            'message'=>'Paciente registrado correctamente'
        );

        return json_encode($json, true);
    }

        //==================================================================================================================================

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
    //==================================================================================================================================

    public function buscarPaciente(Request $request) {
        $datauser = array("nombre"=>$request->input("nombre"));

        $filterData = DB::table('informacion_usuario')
        ->select('*')
        // ->where('nombre', '=', $datauser['nombre'])
        ->where('id_admin', 3)
        ->get();

        
        $json = array(
            'status'=>200,
            'data'=> $filterData,
            'message'=>'Paciente encontrado'
        );

        return json_encode($json, true);

    }

        //==================================================================================================================================

    public function buscarUsuario(Request $request) {
        $datauser = array("nombre"=>$request->input("nombre"));

        $filterData = DB::table('informacion_usuario')
        ->select('*')
        ->get();

        
        $json = array(
            'status'=>200,
            'data'=> $filterData,
            'message'=>'Paciente encontrado'
        );

        return json_encode($json, true);

    }

        //==================================================================================================================================


    public function guardarCita(Request $request) {
        $datauser = array("id_usuario"=>$request->input("id_usuario"),
                          "fecha_cita"=>$request->input("fecha_cita"),
                          "comentarios"=>$request->input("comentarios"),
                          "descripcion_cita"=>$request->input("descripcion_cita"));

        $citaData = new Citas();
        $citaData->id_usuario = $datauser["id_usuario"];;
        $citaData->id_medico = 1;
        $citaData->comentarios = $datauser["comentarios"];
        $citaData->descripcion_cita = $datauser["descripcion_cita"];
        $citaData->fecha_cita = $datauser["fecha_cita"];

        $citaData->save();

        $json = array(
            'status'=>200,
            'message'=>'Cita registrada correctamente'
        );

        return json_encode($json, true);
    }
    //==================================================================================================================================

    public function getCitas() {

        $dataCita = DB::table('citas')
        ->select('fecha_cita', 'descripcion_cita')
        ->get();

        if ($dataCita) {
            $json = array(
                'status'=>200,
                'data'=>$dataCita
            );

        } else {
            $json = array(
                'status'=>404,
                'message'=>'No hay registros'
            );
        }

        return json_encode($json, true);
    }
}
