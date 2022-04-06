<?php

namespace App\Http\Controllers;

use App\Models\BaseModel\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function getSubordinados(Request $request, Usuario $usuario) {
        return self::respuestaDTOSimple('getSubordinados','getSubordinados','getSubordinados',[
            'subordinados' => $usuario->subordinados,
        ]);
    }
}
