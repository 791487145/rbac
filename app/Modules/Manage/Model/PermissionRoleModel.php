<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;
use CommonClass;
use DB;
use Symfony\Component\HttpKernel\Tests\DataCollector\DumpDataCollectorTest;

/**
 * App\Modules\Manage\Model\PermissionRoleModel
 *
 * @property int $permission_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionRoleModel wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\PermissionRoleModel whereRoleId($value)
 * @mixin \Eloquent
 */
class PermissionRoleModel extends Model
{
    protected $table = 'permission_role';

    public $timestamps = false;

    protected $fillable = [
       'permission_id','role_id'
    ];

    protected $guarded = [];

        
}