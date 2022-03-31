<?php

namespace App\Http\Controllers;

use App\Models\BaseModel\Usuario;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
            'dias' => ''
        ]);
        $dias = $request->get('dias', 1);
        $password = $request->get('password');
        $usuario = Usuario::getByUsername($request->user);
        if (!$usuario || !$usuario->comparePassword($password)) {
            return response([
                'message' => 'userNotFound',
                'detail' => 'Datos del usuario ingresado no es valido'
            ], Response::HTTP_FORBIDDEN);
        } else {
            $token = $usuario->generateToken($dias);
            return self::respuestaDTOSimple('login',"Usuario logueado","login",[
                'type' => 'Bearer',
                'token' => $token,
                'expires' => CarbonImmutable::make('now')->timezone('UTC')->addDays($dias)
            ]);
        }
    }

    public function getUser(Request $request)
    {
        return self::respuestaDTOSimple('getuser', 'Usuario obtenido desde token', 'getUser',
            ['usuario' => $request->user()]);
    }
}
