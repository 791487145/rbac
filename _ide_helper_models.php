<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Modules\Manage\Model{
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
	class MenuModel extends \Eloquent {}
}

namespace App\Modules\Manage\Model{
/**
 * App\Modules\Manage\Model\Users
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $qq QQ
 * @property int|null $telephone 电话
 * @property string|null $birthday 生日
 * @property int|null $status 状态-1删除；1：正常
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereTelephone($value)
 * @mixin \Eloquent
 * @property string|null $py 拼音
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel wherePy($value)
 */
	class UsersModel extends \Eloquent {}
}

