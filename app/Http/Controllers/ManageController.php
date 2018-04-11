<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaiseController;
use App\Modules\Manage\Model\MenuModel;
use App\Modules\Manage\Model\MenuPermissionModel;
use App\Modules\Manage\Model\PermissionModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class ManageController extends BaiseController
{
    public $page = 20;
    public $menus;

    public function __construct()
    {
        $route = Route::currentRouteName();
        $permission = PermissionModel::whereName($route)->first();
        if(!is_null($permission))
        {
            $permission = MenuPermissionModel::wherePermissionId($permission['id'])->first();
            $menu = MenuModel::getMenu($permission['menu_id']);

            view()->composer('*',function($view) use($menu){
                $view->with('menu_data',$menu);
            });
        }
    }


    public function formateResponse($code = 1000, $message = 'success', $data = null, $statusCode = 200)
    {
        $result['code'] = $code;
        $result['message'] = $message;
        if (isset($data)) {
            $result['data'] = is_array($data) ? $data : json_decode($data, true);
        } else {
            $result['data'] = new \stdClass();
        }

        return new Response($result, $statusCode);
    }

    //**
    /**
     *  数组排列组合
     */
    static function zhu($arr)
    {
        if(count($arr) >= 2){
            $tmparr = array();
            $arr1 = array_shift($arr);
            $arr2 = array_shift($arr);
            foreach($arr1 as $k1 => $v1){
                foreach($arr2 as $k2 => $v2){
                    $tmparr[] = $v1.$v2;
                }
            }
            array_unshift($arr, $tmparr);
            $arr = self::zuhe($arr);
        }else{
            return $arr;
        }
        return $arr;
    }


}
