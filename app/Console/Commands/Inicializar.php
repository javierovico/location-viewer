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
        Artisan::call('migrate:rollback');
        Artisan::call('migrate:refresh');
        $user1 = Usuario::nuevoUsuario('user1', 'User1','user1');
        $user2 = Usuario::nuevoUsuario('user2', 'User2','user2', $user1);
        $user3 = Usuario::nuevoUsuario('user3', 'User3','user3', $user1);
        $user4 = Usuario::nuevoUsuario('user4', 'User4','user4', $user1);
        return 0;
    }
}
