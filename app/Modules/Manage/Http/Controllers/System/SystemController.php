<?php

namespace App\Modules\Manage\Http\Controllers\System;

use DB;
use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\MenuModel;
use Illuminate\Http\Request;
use CommonClass;

class SystemController extends ManageController
{
    //菜单管理
    public function systemList($id = 0, $level = 1)
    {
        $first_menus = MenuModel::wherePid(MenuModel::MENU_PID)->whereStatus(MenuModel::STATUS_NORMAL)->get();
        $first_menu = MenuModel::whereId($id)->whereStatus(MenuModel::STATUS_NORMAL)->first();

        if($id == 0 || is_null($first_menu)){
            $first_menu = MenuModel::wherePid(MenuModel::MENU_PID)->orderBy('id','asc')->whereStatus(MenuModel::STATUS_NORMAL)->first();
        }

        $first_menu_children = MenuModel::findChildrenMenus($first_menu);
        $count = count($first_menu_children);
        $menus = \CommonClass::listToTree($first_menu_children,$pk='id', $pid = 'pid', $child = '_child', 0);

        $menus = \CommonClass::keyBy($menus,'id');
        $menus = $menus[$first_menu->id];

        $data = array(
            'menus' => $menus,
            'first_menus' => $first_menus,
            'count' => $count,
            'first_menu' => $first_menu
        );

        return view("Manage.system.system_list",$data);
    }

    public function systemCreate(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->except('_token');
            $menu = MenuModel::create($data);

            return $this->formateResponse(1000,'添加菜单成功');
        }
        return view("Manage.system.system_add");
    }

    public function menuAdd($id,Request $request)
    {
        if($request->isMethod('post')){
            $menu = MenuModel::whereId($id)->first();
            $data = $request->except('_token');
            $data['pid'] = $id;
            $data['level'] = $menu->level + 1;
            $menu = MenuModel::create($data);

            return $this->formateResponse(1000,'添加菜单成功');
        }
        return view("Manage.system.system_add");
    }

    public function menuEdit($id,Request $request)
    {
        $menu = MenuModel::whereId($id)->select('name','note','route','sort','icon')->first();
        if($request->isMethod('post')){
            $data = $request->except('_token');
            $menu = $menu->toArray();
            if(!empty(array_diff($data,$menu))){
                MenuModel::whereId($id)->update($data);
            }
            return $this->formateResponse(1000,'修改菜单成功');
        }

        return view('Manage.system.system_edit',compact('menu'));
    }

    public function systemDel(Request $request)
    {
        $id = $request->input('id',0);
        $menu = MenuModel::whereId($id)->first();
        if(is_null($menu)){
            return $this->formateResponse(1001,'暂无找到该菜单');
        }
        $menus = MenuModel::findChildrenMenus($menu);
        $ids = [];
        foreach($menus as $v){
            $ids[] = $v['id'];
        }

        DB::transaction(function ()use ($ids) {
            MenuModel::whereIn('id', $ids)->update(['status' => MenuModel::STATUS_DEL]);
        });
        return $this->formateResponse(1000,'删除成功',$ids);
    }
}
