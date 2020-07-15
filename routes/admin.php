<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

Route::get('/', 'IndexController@index');


Route::get('index', ['as' => 'admin.index', 'uses' => function () {
    return redirect('/admin/log-viewer');
}]);

Route::group(['prefix' => 'errors'], function () {
    Route::get('403', function () {
        return view('admin.errors.403');
    });

    Route::get('404', function () {
        return view('admin.errors.404');
    });

    Route::get('503', function () {
        return view('admin.errors.503');
    });
});

Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin']], function () {

    //權限管理路由
    Route::get('permission/{cid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::get('permission/manage', ['as' => 'admin.permission.manage', 'uses' => 'PermissionController@index']);
    Route::get('permission/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查詢
    Route::resource('permission', 'PermissionController', ['names' => ['update' => 'admin.permission.edit', 'store' => 'admin.permission.create']]);


    //角色管理路由
    Route::get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::post('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController', ['names' => ['update' => 'admin.role.edit', 'store' => 'admin.role.create']]);


    //用戶管理路由
    Route::get('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);  //用戶管理
    Route::post('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController', ['names' => ['update' => 'admin.user.edit', 'store' => 'admin.user.create']]);


    //人資管理系統
    /*Route::get('human/index', ['as' => 'admin.human.index', 'uses' => 'HumanController@index']); 
    Route::post('human/index', ['as' => 'admin.human.index', 'uses' => 'HumanController@index']); 
    Route::resource('human', 'HumanController', ['names' => ['update' => 'admin.human.edit', 'store' => 'admin.human.create']]);*/

});

Route::get('/', function () {
    return redirect('/admin/index');
});

