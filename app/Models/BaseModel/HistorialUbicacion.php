<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialUbicacion extends BaseModel
{
    use HasFactory;
    const tableName = 'historial_ubicacion';
    protected $table = self::tableName;
    protected $primaryKey = self::COLUMNA_ID;
    const COLUMNA_ID = 'id';
    const COLUMNA_USER_ID = 'user_id';
    const COLUMNA_LATITUD = 'latitud';
    const COLUMNA_LONGITUD = 'longitud';

}
