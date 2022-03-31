<?php

namespace App\Models\BaseModel;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @property string user
 * @property string password
 * @see Usuario::setPasswordAttribute()
 * @property string nombre
 * @property integer id
 */
class Usuario extends BaseModel
{
    use HasFactory;
    const tableName = 'usuarios';
    protected $table = self::tableName;
    protected $primaryKey = self::COLUMNA_ID;
    const COLUMNA_ID = 'id';
    const COLUMNA_USER = 'user';
    const COLUMNA_PASSWORD = 'password';
    const COLUMNA_NOMBRE = 'nombre';

    protected $hidden = [
        self::COLUMNA_PASSWORD
    ];

    public static function nuevoUsuario($usuario, $nombre, $password)
    {
        $nuevo = new self();
        $nuevo->user = $usuario;
        $nuevo->password = $password;
        $nuevo->nombre = $nombre;
        $nuevo->save();
    }

    public static function getByUsername($user): ?self
    {
        return self::where(self::COLUMNA_USER, $user)->first();
    }

    public function setPasswordAttribute($att)
    {
        $this->attributes[self::COLUMNA_PASSWORD] = Hash::make($att);
    }

    public function comparePassword($pass): bool
    {
        return Hash::check($pass, $this->password);
    }

    public function generateToken($dias)
    {
        $userId =  $this->id;
        $secretKey  = env('LOGIN_API_KEY');
        $tokenId    = base64_encode(random_bytes(16));
        $issuedAt   = new Carbon();
        $expire     = (new Carbon($issuedAt))->addDays($dias)->getTimestamp();
        $serverName = env('APP_NAME');
        return JWT::encode(
            [
                'iat'  => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
                'jti'  => $tokenId,                     // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,                  // Issuer
                'nbf'  => $issuedAt->getTimestamp(),    // Not before
                'exp'  => $expire,                      // Expire
                'data' => [                             // Data related to the signer user
                    'userId' => $userId,
                ]
            ],      //Data to be encoded in the JWT
            $secretKey, // The signing key
            'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );
    }
}
