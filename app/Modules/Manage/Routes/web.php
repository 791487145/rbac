<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'manage'], function () {
    Route::get('/', function () {
        dd('This is the Manage module index page. Build something great!');
    });
    Route::get('/login','Auth\LoginController@getLogin');
    Route::get('/home','Auth\HomeController@index');
    Route::post('/login','Auth\LoginController@postLogin');
});

Route::group(['prefix' => 'manage','middleware' => ['role.permission']], function () {

    Route::get('/index','Dash\IndexController@index')->name('index');

    //系统管理
    Route::namespace('System')->group(function () {
        //菜单管理
        Route::get('system/menu/{id}/{level}','SystemController@systemList');
        Route::match(['get', 'post'], 'system/menu/create', 'SystemController@systemCreate');
        Route::match(['get', 'post'], 'system/{id}/menuedit', 'SystemController@menuEdit');
        Route::match(['get', 'post'], 'system/{id}/menuadd', 'SystemController@menuAdd');
        Route::post('system/menu/delete','SystemController@systemDel');
    });

    //管理员管理
    Route::namespace('Admin')->group(function () {
        //系统用户管理
        Route::get('admin/systemUser/list','AdminController@systemUser')->name('systemUser');
        Route::match(['get', 'post'], 'admin/systemUser/create', 'AdminController@systemUserCreate')->name('systemUserCreate');
        Route::match(['get', 'post'], 'admin/{id}/systemUserEdit', 'AdminController@systemUserEdit')->name('systemUserEdit');
        Route::put('admin/systemUser/operation','AdminController@systemUserOperation')->name('systemUserOperation');
        Route::delete('admin/systemUser/delete','AdminController@systemUserDelete');
        //角色管理
        Route::get('admin/systemRole/list','AdminController@systemRole')->name('systemRole');
        Route::match(['get', 'post'], 'admin/systemRole/create', 'AdminController@systemRoleCreate')->name('systemRoleCreate');
        Route::match(['get', 'post'], 'admin/{id}/systemRoleEdit', 'AdminController@systemRoleEdit')->name('systemRoleEdit');
        Route::delete('admin/systemRole/delete','AdminController@systemRoleDelete');
        //权限管理
        Route::get('admin/systemPermission/list','AdminController@systemPermission')->name('systemPermission');
        Route::match(['get', 'post'], 'admin/systemPermission/create', 'AdminController@systemPermissionCreate')->name('permissionAdd');
        Route::match(['get', 'post'], 'admin/{id}/systemPermissionEdit', 'AdminController@systemPermissionEdit')->name('permissionEdit');
        Route::delete('admin/systemPermission/delete','AdminController@systemPermissionDelete');

    });


});
