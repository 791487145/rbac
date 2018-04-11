<?php

namespace App\Http\Middleware;

use App\Modules\Manage\Model\ManagerModel;
use Illuminate\Support\Facades\Redis;
use App\Modules\Manage\Model\UsersModel;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


class RolePermission
{

    public function handle($request, Closure $next)
    {
        $route = Route::currentRouteName();

        $manager = UsersModel::getManagerSession();

        $user = $manager->name;
        $user = UsersModel::where('users.name',$user)
                        ->leftJoin('role_user','role_user.user_id','=','users.id')
                        ->leftJoin('roles','roles.id','=','role_user.role_id')
                        ->select('users.id','roles.id as role_id')
                        ->first();

        $permissions = Redis::get($user->role_id);
        if(empty($permissions)){
            return redirect()->back()->with(['message' => '没有权限']);
        }

        if(strpos($permissions,$route) === false){
            return redirect()->back()->with(['message' => '没有权限']);
        }

        return $next($request);
    }
}
