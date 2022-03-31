<?php


namespace App\Models\BaseModel;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    const CONNECTION_DB = 'conexion_db_default';
    protected $connection = self::CONNECTION_DB;
    const tableName = 'forge';

}
