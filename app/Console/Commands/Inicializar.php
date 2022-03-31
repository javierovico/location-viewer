<?php

namespace App\Console\Commands;

use App\Models\BaseModel\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Inicializar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inicializar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('migrate:refresh');
        $usuario = 'user1';
        $nombre = 'User1';
        $password ='user1';
        Usuario::nuevoUsuario($usuario, $nombre,$password);
        return 0;
    }
}
