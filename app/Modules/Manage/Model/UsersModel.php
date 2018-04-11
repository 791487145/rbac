<?php

namespace App\Modules\Manage\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaiseController;


/**
 * App\Modules\Manage\Model\Users
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $qq QQ
 * @property string|null $birthday 生日
 * @property int|null $status 状态-1删除；1：正常
 * @property string|null $py 拼音
 * @property string|null $telephone 电话
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel wherePy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereTelephone($value)
 * @mixin \Eloquent
 * @property string|null $remark
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Manage\Model\UsersModel whereRemark($value)
 */
class UsersModel extends Model
{
    const STATUS_DEL = -1;//删除
    const STATUS_NORMAL = 1;//正常
    const STATUS_FORBIDDEN = 2;//禁用

    protected $table = 'users';

    public $timestamps = true;

    protected $fillable = [
       'id','name','email','password','remember_token','status','birthday','telephone','py'
    ];

    protected $guarded = [];

    static function createOne($data)
    {
        $ret = DB::transaction(function () use($data) {
            $salt = \CommonClass::random(4);
            $users = new UsersModel();
            $users->name = $data['name'];
            $users->email = $data['email'];
            $users->password = self::encryptPassword($data['password'], $salt);
            $users->telephone = $data['telephone'];
            $users->py = app('pinyin')->sentence($data['name']);
            $users->remember_token = $salt;
            $users->save();
            return $users;
        });
        return $ret;
    }

    static function userAndRole($user)
    {
        $user = $user ->leftJoin('role_user','role_user.user_id','=','users.id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->select('users.*','roles.name as role_name','roles.id as role_id');
        return $user;
    }

    static function encryptPassword($password, $sign = '')
    {
        return md5(md5($password . $sign));
    }

    static function getpassword($credentials)
    {
        $user = self::whereName($credentials['name'])->first();
        $password = self::encryptPassword($credentials['password'],$user->remember_token);
        return $password;
    }

    static function managerLogin($manager)
    {
        return Session::put('manager', $manager);
    }

    static function getManagerSession()
    {
        return Session::get('manager');
    }
        
}