<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;
use CommonClass;
use Symfony\Component\HttpKernel\Tests\DataCollector\DumpDataCollectorTest;

/**
 * App\Modules\Manage\Model\PermissionModel
 *
 * @property int $id
 * @property string $name 菜单名
 * @property string|null $display_name 路由名称
 * @property string|null $description
 * @property int|null $display_order 排序
 * @property int|null $module_type 所属模型
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereModuleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermissionModel extends Model
{
    protected $table = 'permissions';

    public $timestamps = true;

    protected $fillable = [
        'id','name','display_name','description','module_type','display_order'
    ];

    protected $guarded = [];

    //创建菜单
    static function create($data){
        $permission = new PermissionModel();
        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->module_type = $data['module_type'];
        $permission->display_order = $data['display_order'];
        $permission->save();

        return $permission;
    }

    //权限菜单
    static function peimissionOfMenu()
    {
        $permissions = self::leftJoin('menu','menu.id','=','permissions.module_type')
                        ->select('permissions.*','menu.name as menu_name')
                        ->orderBy('permissions.id','desc');
        return $permissions;
    }

    static public function getPermissionMenu()
    {
        $menu_all = MenuModel::whereStatus(MenuModel::STATUS_NORMAL)->get()->toArray();
        foreach($menu_all as $k=>$v)
        {
            $menu_all[$k]['fid'] = $v['id'];
        }

        $permission_all = self::all()->toArray();

        $menu_permission = MenuPermissionModel::all()->toArray();
        $menu_permission = \CommonClass::keyBy($menu_permission,'permission_id');

        foreach($permission_all as $k=>$v)
        {
            $permission_all[$k]['pid'] = $menu_permission[$v['id']]['menu_id'];
            $permission_all[$k]['fid'] = 0;
            $permission_all[$k]['name'] = $v['name'];
        }

        $permission_menu = array_merge($menu_all,$permission_all);
        $permission_menu_tree = \CommonClass::listToTree($permission_menu,'fid','pid');
        return $permission_menu_tree;
    }
        
}