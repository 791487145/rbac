<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;
use CommonClass;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Tests\DataCollector\DumpDataCollectorTest;


/**
 * App\Modules\Manage\Model\Menu
 *
 * @property int $id 自增索引
 * @property string|null $name 菜单名称
 * @property string|null $route 路由
 * @property int $pid 父级id
 * @property int|null $level 菜单等级
 * @property string|null $note 菜单说明信息
 * @property int $sort 排序
 * @property string|null $icon 图标
 * @property int|null $status 0:删除；1：正常
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuModel whereIcon($value)
 * @mixin \Eloquent
 */
class MenuModel extends Model
{
    const MENU_PID = 0;//顶级菜单

    const MENU_LEVEL_TOP = 0;//顶级菜单
    const MENU_LEVEL_SECOND = 1;//一级菜单
    const MENU_LEVEL_THIRD = 2;//二级菜单

    const STATUS_DEL = 0;//删除
    const STATUS_NORMAL = 1;//正常

    protected $table = 'menu';

    public $timestamps = true;

    protected $fillable = [
       'id','name','route','pid','level','note','sort','status','icon'
    ];

    protected $guarded = [];

    //创建菜单
    static function create($data){
        $menu = new MenuModel();
        $menu->name = $data['name'];
        $menu->route = $data['route'];
        $menu->sort = $data['sort'];
        $menu->level = isset($data['level']) ? $data['level'] : 0;
        $menu->pid = isset($data['pid']) ? $data['pid'] : 0;
        $menu->note = $data['note'];
        $menu->save();

        return $menu;
    }

    //相关全部菜单
    static function findChildrenMenus($menu){
        $menus[] = $menu->toArray();
        $_child = self::wherePid($menu->id)->whereStatus(self::STATUS_NORMAL)->orderBy('sort','asc')->get();

        if(!$_child->isEmpty()){
            foreach($_child as $v){
                $menus[] = $v->toArray();
                $_children = self::wherePid($v->id)->whereStatus(self::STATUS_NORMAL)->orderBy('sort','asc')->get();
                if(!$_children->isEmpty()){
                    foreach($_children as $val){
                        $menus[] = $val->toArray();
                    }
                }
            }
        }
        return $menus;
    }

    //获取所有菜单
    static function getMenuPermission()
    {
        $manager = UsersModel::getManagerSession();

        $uid = $manager->id;

        $role_id = RoleUserModel::whereUserId($uid)->first();
        $permission = PermissionRoleModel::whereRoleId($role_id['role_id'])->pluck('permission_id')->toArray();
        $menu_ids = MenuPermissionModel::whereIn('permission_id',$permission)->pluck('menu_id')->toArray();
        $menu_ids = array_unique($menu_ids);

        $third_menu = self::whereIn('id',$menu_ids)->where('level',2)->whereStatus(self::STATUS_NORMAL)->pluck('id')->toArray();
        $second_menu = self::whereIn('id',$menu_ids)->where('level',1)->whereStatus(self::STATUS_NORMAL)->pluck('id')->toArray();
        $first_menu = self::whereIn('id',$menu_ids)->where('level',0)->whereStatus(self::STATUS_NORMAL)->pluck('id')->toArray();

        $manageMenuAll = self::whereStatus(self::STATUS_NORMAL)->get()->toArray();

        foreach($manageMenuAll as $k=>$v)
        {
            if($v['level']==2 && !in_array($v['id'],$third_menu))
            {
                $manageMenuAll = array_except($manageMenuAll,[$k]);
            }
        }

        $manageMenuAllTree = \CommonClass::listToTree($manageMenuAll);

        foreach($manageMenuAllTree as $key=>$value)
        {
            if(!empty($value['_child'])) {
                foreach ($value['_child'] as $menukey => $menu) {
                    if (empty($menu['_child']) && !in_array($menu['id'], $second_menu)) {
                        $manageMenuAllTree[$key]['_child'] = array_except($manageMenuAllTree[$key]['_child'], [$menukey]);
                    }
                }
            }elseif(empty($value['_child']) && !in_array($value['id'],$first_menu))
            {
                $manageMenuAllTree = array_except($manageMenuAllTree,[$key]);
            }
        }

        foreach($manageMenuAllTree as $m=>$n)
        {
            if(empty($n['_child']) && !in_array($n['id'],$first_menu))
            {
                $manageMenuAllTree = array_except($manageMenuAllTree,[$m]);
            }
        }

        return $manageMenuAllTree;
    }

    static function getMenu($id)
    {
        $menu = self::where('id',$id)->first();
        if($menu['level']==1)
        {
            $menu_secound = self::where('id',$menu['pid'])->first()->toArray();
            $menu_data = [$menu,$menu_secound];
            $menu_ids = [$menu['id'],$menu_secound['id']];
        }elseif($menu['level']==2)
        {
            $menu_secound = self::where('id',$menu['pid'])->first()->toArray();
            $menu_third = self::where('id',$menu_secound['pid'])->first()->toArray();
            $menu_data = [$menu,$menu_secound,$menu_third];
            $menu_ids = [$menu['id'],$menu_secound['id'],$menu_third['id']];
        }else
        {
            $menu_data = \CommonClass::listToTree($menu);
            $menu_ids = [$menu['id']];
        }
        $menu_data = \CommonClass::listToTree($menu_data);
        $data = [
            'menu_data'=>$menu_data,
            'menu_ids'=>$menu_ids
        ];
        return $data;
    }



        
}