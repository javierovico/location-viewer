<?php

use App\Models\BaseModel\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Usuario::CONNECTION_DB)->create(Usuario::tableName, function (Blueprint $table) {
            $table->id(Usuario::COLUMNA_ID);
            $table->foreignId(Usuario::COLUMNA_SUPERVISOR_ID)->nullable()->references(Usuario::COLUMNA_ID)->on(Usuario::tableName)->nullOnDelete();
            $table->string(Usuario::COLUMNA_USER,100)->unique();
            $table->string(Usuario::COLUMNA_PASSWORD,250);
            $table->string(Usuario::COLUMNA_NOMBRE,100);
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
        Schema::connection(Usuario::CONNECTION_DB)->dropIfExists(Usuario::tableName);
    }
}
