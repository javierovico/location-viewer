<?php

namespace App\Http\Middleware;

use App\Exceptions\RootException;
use App\Models\BaseModel\Usuario;
use Carbon\Carbon;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws RootException
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization', '');
        if ( preg_match('/^Bearer (\S+)$/', $authorization, $salida)) {
            $jwt = $salida[1];
            try{
                $request->merge(['userTokenBearer' => $jwt]);
                JWT::$leeway += 60;
                $token = JWT::decode($jwt, new Key(env('LOGIN_API_KEY'), 'HS512'));
                $now = new Carbon();
                $serverName = env('APP_NAME');
                if ($token->iss !== $serverName ||
                    $token->nbf > $now->getTimestamp() ||
                    $token->exp < $now->getTimestamp())
                {
                    throw RootException::createException( 'No autorizado(TOKEN VENCIDO)','tkn_vnc', "No autorizado",Response::HTTP_FORBIDDEN);
                }
                $usuario = Usuario::find($token->data->userId);
                if (!$usuario) {
                    throw RootException::createException( 'El usuario ya no existe','tkn_inv', "No autorizado",Response::HTTP_FORBIDDEN);
                }
            }catch (ExpiredException | SignatureInvalidException | UnexpectedValueException $e){
                throw RootException::createException( 'No autorizado(TOKEN Invalido)','tkn_inv', "No autorizado",Response::HTTP_FORBIDDEN);
            }
            $request->setUserResolver(function () use ($usuario) {
                return $usuario;
            });
            return $next($request);
        } else {
            throw RootException::createException( 'No autorizado(TOKEN no encontrado en header)','tkn_inv', "No autorizado",Response::HTTP_FORBIDDEN);
        }
    }
}
