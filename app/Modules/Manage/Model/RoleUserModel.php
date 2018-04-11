<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Manage\Model\RoleUserModel
 *
 * @property int $user_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RoleUserModel whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\RoleUserModel whereUserId($value)
 * @mixin \Eloquent
 */
class RoleUserModel extends Model
{
    protected $table = 'role_user';

    public $timestamps = false;

    protected $fillable = [
       'user_id','role_id'
    ];

    protected $guarded = [];

        
}