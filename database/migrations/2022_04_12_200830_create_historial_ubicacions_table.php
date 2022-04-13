<?php

use App\Models\BaseModel\HistorialUbicacion;
use App\Models\BaseModel\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialUbicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(HistorialUbicacion::CONNECTION_DB)->create(HistorialUbicacion::tableName, function (Blueprint $table) {
            $table->id(HistorialUbicacion::COLUMNA_ID);
            $table->foreignId(HistorialUbicacion::COLUMNA_USER_ID)->references(Usuario::COLUMNA_ID)->on(Usuario::tableName)->cascadeOnDelete();
            $table->float(HistorialUbicacion::COLUMNA_LATITUD);
            $table->float(HistorialUbicacion::COLUMNA_LONGITUD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(HistorialUbicacion::CONNECTION_DB)->dropIfExists(HistorialUbicacion::tableName);
    }
}
