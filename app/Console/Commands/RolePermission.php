<?php

namespace App\Console\Commands;

use App\Modules\Manage\Model\RolesModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RolePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rolepermission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users have permissions';

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
     * @return mixed
     */
    public function handle()
    {
        $role_permission = RolesModel::roleAndPermission();
        foreach($role_permission as $k=>$value){
            Redis::set($k,$value);
        }
    }
}
