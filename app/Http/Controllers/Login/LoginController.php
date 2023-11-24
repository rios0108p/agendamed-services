<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

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

        $dataLogin = DB::table('users')
        ->select('UserName', 'Password')
        ->where('UserName', '=', $datauser['userName'])
        ->where('Password', '=', $datauser['password'])
        ->exists();

        if ($dataLogin) {
            $json = array(
                'status'=>200,
                'data'=>$datauser,
                'message'=>$dataLogin
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
