<?php

namespace App\Modules\Manage\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaiseController;



/**
 * App\Modules\Manage\Model\RolesModel
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RolesModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RolesModel extends Model
{
    protected $table = 'roles';

    public $timestamps = true;

    protected $fillable = [
       'id','name','display_name','description'
    ];

    protected $guarded = [];

    static function roleAndPermission()
    {
        $param = array();
        $role_permissions = self::leftJoin('permission_role','permission_role.role_id','=','roles.id')
            ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
            ->select('roles.id','permissions.name as permission_name')
            ->get();

        foreach($role_permissions as $role_permission){
            $param[$role_permission->id][] = $role_permission->permission_name;
        }
        foreach($param as &$v){
            $v = implode(',',$v);
        }
        return $param;
    }


        
}