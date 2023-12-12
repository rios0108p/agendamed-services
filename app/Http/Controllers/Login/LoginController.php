<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class LoginController extends Controller
{
    public function index() {
        $json = array(
            "user"=> "logueado"
        );

        echo json_encode($json, true);
    }

    public function login(Request $request) {

        $datauser = array("userName"=>$request->input("userName"),
        "password"=>$request->input("password"));

        $dataLogin = DB::table('credenciales')
        ->select('id_usuario', 'usuario', 'contrasena')
        ->where('usuario', '=', $datauser['userName'])
        ->where('contrasena', '=', $datauser['password'])
        ->get();

        $rol = json_decode($dataLogin, true);
        //Despues de buscar si existe el usuario en la tabla de credenciales,
        //Se busca en la tabla de informacion_usuario el rol para saber que mostrar al usuario
        $datarol = DB::table('informacion_usuario')
        ->select('id_admin', 'id_info_usuario')
        ->where('id_info_usuario', '=', $rol[0]['id_usuario'])
        ->get();

        if ($dataLogin != []) {
            //Respuesta en formato json al encontrar data y el rol
            $json = array(
                'status'=>200,
                'data'=>$datauser,
                'rol'=>$datarol
            );

        } else {
            $json = array(
                'status'=>404,
                'message'=>'Usuario no encontrado'
            );
        }

        return json_encode($json, true);
    }

    public function saveUser(Request $request) {

        $datauser = array("userName"=>$request->input("userName"),
                          "password"=>$request->input("password"));

        $userData = new Users();
        $userData->UserName = $datauser["userName"];
        $userData->Password = $datauser["password"];
        $userData->IdRole = 1;

        $userData->save();

        $json = array(
            'status'=>200,
            'message'=>'Usuario registrado correctamente'
        );

        return json_encode($json, true);
    }
}
