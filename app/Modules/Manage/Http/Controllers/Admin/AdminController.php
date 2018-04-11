<?php

namespace App\Modules\Manage\Http\Controllers\Admin;

use App\Modules\Manage\Model\MenuPermissionModel;
use App\Modules\Manage\Model\PermissionModel;
use App\Modules\Manage\Model\PermissionRoleModel;
use App\Modules\Manage\Model\RolesModel;
use App\Modules\Manage\Model\RoleUserModel;
use App\Modules\Manage\Model\UsersModel;
use DB;
use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\MenuModel;
use Illuminate\Http\Request;

class AdminController extends ManageController
{
    //系统用户
    public function systemUser(Request $request)
    {
        $users = UsersModel::whereIn('users.status',[UsersModel::STATUS_NORMAL,UsersModel::STATUS_FORBIDDEN]);
        $users = UsersModel::userAndRole($users);
        $users = $users->paginate($this->page);

        $data = array(
            'users' => $users,
        );
        return view("Manage.admin.admin_list",$data);
    }

    public function systemUserCreate(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->except('_token');
            $email = UsersModel::whereEmail($data['email'])->first();
            if (!is_null($email)) {
                return $this->formateResponse(1001, '该邮箱已注册');
            }
            $ret = UsersModel::createOne($data);
            if (!is_null($ret)) {
                $param = array(
                    'user_id' => $ret->id,
                    'role_id' => $data['role_id'],
                );
                RoleUserModel::insert($param);
                return $this->formateResponse(1000, '注册成功');
            }
        }
        $roles = RolesModel::all();
        $data = array(
            'roles' => $roles
        );
        return view("Manage.admin.admin_add",$data);
    }

    public function systemUserEdit($id,Request $request)
    {
        $user = UsersModel::where('users.id',$id);
        $user = UsersModel::userAndRole($user);
        $user = $user->first();

        if($request->isMethod('post')){
            $data = $request->all();
            $param = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'telephone' => $data['telephone']
            );
            UsersModel::whereId($id)->update($param);
            if($user->role_id != $data['role_id']){
                $role_user = RoleUserModel::whereUserId($id)->first();
                RoleUserModel::whereUserId($id)->update(['role_id' => $data['role_id']]);
                if(is_null($role_user)){
                    $param1 = array(
                        'role_id' => $data['role_id'],
                        'user_id' => $id
                    );
                    RoleUserModel::insert($param1);
                }
            }
            return $this->formateResponse(1000,'修改成功');
        }


        $roles = RolesModel::all();
        $data = array(
            'user' => $user,
            'roles' => $roles
        );
        return view("Manage.admin.admin_edit",$data);
    }

    public function systemUserOperation(Request $request)
    {
        $ret = UsersModel::whereId($request->input('id'))->update(['status' => $request->input('status')]);
        if($ret){
            return $this->formateResponse(1000,'修改成功');
        }
        return $this->formateResponse(1001,'修改失败');
    }

    public function systemUserDelete(Request $request)
    {
        DB::transaction(function () use ($request) {
            UsersModel::whereId($request->input('id'))->update(['status' => UsersModel::STATUS_DEL]);
            RoleUserModel::whereUserId($request->input('id'))->delete();
        });
        return $this->formateResponse(1000,'删除成功');
    }

    //角色
    public function systemRole(Request $request)
    {
        $rules = RolesModel::paginate($this->page);
        $data = array(
            'rules' => $rules
        );
        return view("Manage.admin.admin_role_list",$data);
    }

    public function systemRoleEdit($id,Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->except("_token");
            $param1 = array(
                'name' => $data['name'],
                'description' => $data['description']
            );
            RolesModel::whereId($id)->update($param1);
            PermissionRoleModel::whereRoleId($id)->delete();
            if(!empty($data['menu_grandchildren'])){
                foreach($data['menu_grandchildren'] as $grandchild){
                    $param2 = array(
                        'permission_id' => $grandchild,
                        'role_id' => $id
                    );

                    PermissionRoleModel::insert($param2);
                }
            }
            $this->formateResponse(1000,'修改成功');
        }

        $permissions = PermissionModel::getPermissionMenu();
        $role = RolesModel::whereId($id)->first();
        $role_permission = RolesModel::where('roles.id',$id)
            ->leftJoin('permission_role','permission_role.role_id','=','roles.id')
            ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
            ->select('roles.id','roles.name','permissions.id as permission_id')
            ->get();

        foreach($role_permission as $value){
            $ids[] = $value->permission_id;
        }

        $data = array(
            'permissions' => $permissions,
            'role' => $role,
            'role_permission' => $role_permission,
            'ids' => $ids
        );
        return view("Manage.admin.admin_role_edit",$data);
    }

    public function systemRoleCreate(Request $request)
    {
        $permissions = PermissionModel::getPermissionMenu();

        if($request->isMethod('post')){
            $data = $request->except("_token");
            $param1 = array(
                'name' => $data['roleName'],
                'description' => $data['description'],
                'created_at' => date("Y-m-d H:i:s"),
            );
            $role_id = RolesModel::insertGetId($param1);

            if(!empty($data['menu_grandchildren'])){
                foreach($data['menu_grandchildren'] as $grandchild){
                    $param2 = array(
                        'permission_id' => $grandchild,
                        'role_id' => $role_id
                    );

                    PermissionRoleModel::insert($param2);
                }
            }
            return $this->formateResponse(1000,'添加成功');
        }

        $data = array(
            'permissions' => $permissions
        );
        return view("Manage.admin.admin_role_add",$data);
    }

    public function systemRoleDelete(Request $request)
    {
        DB::transaction(function () use ($request) {
            RolesModel::whereId($request->input('id'))->delete();
            PermissionRoleModel::whereRoleId($request->input('id'))->delete();
        });
        return $this->formateResponse(1000,'删除成功');
    }

    //权限
    public function systemPermission(Request $request)
    {
        $permissions = PermissionModel::peimissionOfMenu();
        $permissions = $permissions->paginate($this->page);
        $data = array(
            'permissions' => $permissions
        );
        return view("Manage.admin.admin_permission_list",$data);
    }

    public function systemPermissionCreate(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->except('_token');
            $permission = PermissionModel::create($data);
            $param = array(['permission_id' =>$permission->id,'menu_id' => $data['module_type']]);

            MenuPermissionModel::insert($param);
            $this->formateResponse(1000,'添加成功');
        }

        $menus = MenuModel::getMenuPermission();//TODO::优化

        $data = array(
            'menus' => $menus
        );
        return view("Manage.admin.admin_permission_add",$data);
    }

    public function systemPermissionEdit($id,Request $request)
    {
        $permission = PermissionModel::whereId($id)->first();

        if($request->isMethod('post')){
            $data = $request->except('_token');
            PermissionModel::whereId($id)->update($data);
            MenuPermissionModel::wherePermissionId($id)->delete();
            $param = array(['permission_id' =>$id,'menu_id' => $data['module_type']]);
            MenuPermissionModel::insert($param);
            $this->formateResponse(1000,'修改成功');
        }

        $menus = MenuModel::getMenuPermission();//TODO::优化
        $data = array(
            'menus' => $menus,
            'permission' => $permission
        );
        return view("Manage.admin.admin_permission_edit",$data);
    }

    public function systemPermissionDelete(Request $request)
    {
        DB::transaction(function () use($request) {
            PermissionModel::whereId($request->input('id'))->delete();
            PermissionRoleModel::wherePermissionId($request->input('id'))->delete();
            MenuPermissionModel::wherePermissionId($request->input('id'))->delete();
        });
        return $this->formateResponse(1000,'删除成功');
    }
}
