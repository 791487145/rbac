<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;
use CommonClass;
use Symfony\Component\HttpKernel\Tests\DataCollector\DumpDataCollectorTest;

/**
 * App\Modules\Manage\Model\MenuPermissionModel
 *
 * @property int $id
 * @property int $menu_id
 * @property int $permission_id 菜单名
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuPermissionModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuPermissionModel whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\MenuPermissionModel wherePermissionId($value)
 * @mixin \Eloquent
 */
class MenuPermissionModel extends Model
{
    protected $table = 'menu_permissions';

    public $timestamps = false;

    protected $fillable = [
       'permission_id','menu_id','id'
    ];

    protected $guarded = [];

        
}