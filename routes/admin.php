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

//Route::get('/', 'IndexController@index');


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

//Route::get('customer/register', 'CustomerController@register'); 
Route::post('customer/register', 'CustomerController@store');

Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin']], function () {

    //儀表版
    Route::get('/', ['as' => 'admin.index', 'uses' => function () {
        return redirect('/admin/log-viewer');
    }]);

    //權限管理
    Route::get('permission/{cid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::get('permission/manage', ['as' => 'admin.permission.manage', 'uses' => 'PermissionController@index']);
    Route::get('permission/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查詢
    Route::resource('permission', 'PermissionController', ['names' => ['update' => 'admin.permission.edit', 'store' => 'admin.permission.create']]);


    //角色管理
    Route::get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::post('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController', ['names' => ['update' => 'admin.role.edit', 'store' => 'admin.role.create']]);


    //用戶管理
    Route::get('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::post('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController', ['names' => ['update' => 'admin.user.edit', 'store' => 'admin.user.create']]);

    //店別管理
    Route::get('store/index', ['as' => 'admin.store.index', 'uses' => 'StoreController@index']); 
    Route::post('store/index', ['as' => 'admin.store.index', 'uses' => 'StoreController@index']); 
    Route::resource('store', 'StoreController', ['names' => ['update' => 'admin.store.edit', 'store' => 'admin.store.create']]);

    //客戶管理
    Route::get('customer/index', ['as' => 'admin.customer.index', 'uses' => 'CustomerController@index']); 
    Route::post('customer/index', ['as' => 'admin.customer.index', 'uses' => 'CustomerController@index']); 
    Route::resource('customer', 'CustomerController', ['names' => ['update' => 'admin.customer.edit', 'store' => 'admin.customer.create']]);

    //縣市
    Route::get('counties/index', ['as' => 'admin.counties.index', 'uses' => 'CountiesController@index']); 
    Route::post('counties/index', ['as' => 'admin.counties.index', 'uses' => 'CountiesController@index']); 
    Route::resource('counties', 'CountiesController', ['names' => ['update' => 'admin.counties.edit', 'store' => 'admin.counties.create']]);

    //鄉鎮區
    Route::get('town/index', ['as' => 'admin.town.index', 'uses' => 'TownController@index']); 
    Route::post('town/index', ['as' => 'admin.town.index', 'uses' => 'TownController@index']); 
    Route::resource('town', 'TownController', ['names' => ['update' => 'admin.town.edit', 'store' => 'admin.town.create']]);

    //居住社區
    Route::get('community/index', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']); 
    Route::post('community/index', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']); 
    Route::resource('community', 'CommunityController', ['names' => ['update' => 'admin.community.edit', 'store' => 'admin.community.create']]);

    //會員種類
    Route::get('customer-category/index', ['as' => 'admin.customer-category.index', 'uses' => 'CustomerCategoryController@index']); 
    Route::post('customer-category/index', ['as' => 'admin.customer-category.index', 'uses' => 'CustomerCategoryController@index']); 
    Route::resource('customer-category', 'CustomerCategoryController', ['names' => ['update' => 'admin.customer-category.edit', 'store' => 'admin.customer-category.create']]);

    //專屬服務
    Route::get('customer-service/index', ['as' => 'admin.customer-service.index', 'uses' => 'CustomerServiceController@index']); 
    Route::post('customer-service/index', ['as' => 'admin.customer-service.index', 'uses' => 'CustomerServiceController@index']); 
    Route::resource('customer-service', 'CustomerServiceController', ['names' => ['update' => 'admin.customer-service.edit', 'store' => 'admin.customer-service.create']]);

    //專案資料
    Route::get('customer-project/index', ['as' => 'admin.customer-project.index', 'uses' => 'CustomerProjectController@index']); 
    Route::post('customer-project/index', ['as' => 'admin.customer-project.index', 'uses' => 'CustomerProjectController@index']); 
    Route::resource('customer-project', 'CustomerProjectController', ['names' => ['update' => 'admin.customer-project.edit', 'store' => 'admin.customer-project.create']]);

    //產品類別
    Route::get('product-category/index', ['as' => 'admin.product-category.index', 'uses' => 'ProductCategoryController@index']); 
    Route::post('product-category/index', ['as' => 'admin.product-category.index', 'uses' => 'ProductCategoryController@index']); 
    Route::resource('product-category', 'ProductCategoryController', ['names' => ['update' => 'admin.product-category.edit', 'store' => 'admin.product-category.create']]);

    //產品資料
    Route::get('product/index', ['as' => 'admin.product.index', 'uses' => 'ProductController@index']); 
    Route::post('product/index', ['as' => 'admin.product.index', 'uses' => 'ProductController@index']); 
    Route::resource('product', 'ProductController', ['names' => ['update' => 'admin.product.edit', 'store' => 'admin.product.create']]);

    //行業別
    Route::get('industry/index', ['as' => 'admin.industry.index', 'uses' => 'IndustryController@index']); 
    Route::post('industry/index', ['as' => 'admin.industry.index', 'uses' => 'IndustryController@index']); 
    Route::resource('industry', 'IndustryController', ['names' => ['update' => 'admin.industry.edit', 'store' => 'admin.industry.create']]);

    //休閒娛樂
    Route::get('entertainment/index', ['as' => 'admin.entertainment.index', 'uses' => 'EntertainmentController@index']); 
    Route::post('entertainment/index', ['as' => 'admin.entertainment.index', 'uses' => 'EntertainmentController@index']); 
    Route::resource('entertainment', 'EntertainmentController', ['names' => ['update' => 'admin.entertainment.edit', 'store' => 'admin.entertainment.create']]);

    //旅行模式
    Route::get('tour/index', ['as' => 'admin.tour.index', 'uses' => 'TourController@index']); 
    Route::post('tour/index', ['as' => 'admin.tour.index', 'uses' => 'TourController@index']); 
    Route::resource('tour', 'TourController', ['names' => ['update' => 'admin.tour.edit', 'store' => 'admin.tour.create']]);

    //收藏嗜好
    Route::get('hobby/index', ['as' => 'admin.hobby.index', 'uses' => 'HobbyController@index']); 
    Route::post('hobby/index', ['as' => 'admin.hobby.index', 'uses' => 'HobbyController@index']); 
    Route::resource('hobby', 'HobbyController', ['names' => ['update' => 'admin.hobby.edit', 'store' => 'admin.hobby.create']]);

    //車輛品牌
    Route::get('vehicle-brand/index', ['as' => 'admin.vehicle-brand.index', 'uses' => 'VehicleBrandController@index']); 
    Route::post('vehicle-brand/index', ['as' => 'admin.vehicle-brand.index', 'uses' => 'VehicleBrandController@index']); 
    Route::resource('vehicle-brand', 'VehicleBrandController', ['names' => ['update' => 'admin.vehicle-brand.edit', 'store' => 'admin.vehicle-brand.create']]);

    //品牌車系
    Route::get('brand-series/index', ['as' => 'admin.brand-series.index', 'uses' => 'BrandSeriesController@index']); 
    Route::post('brand-series/index', ['as' => 'admin.brand-series.index', 'uses' => 'BrandSeriesController@index']); 
    Route::resource('brand-series', 'BrandSeriesController', ['names' => ['update' => 'admin.brand-series.edit', 'store' => 'admin.brand-series.create']]);

    //車輛顏色
    Route::get('vehicle-color/index', ['as' => 'admin.vehicle-color.index', 'uses' => 'VehicleColorController@index']); 
    Route::post('vehicle-color/index', ['as' => 'admin.vehicle-color.index', 'uses' => 'VehicleColorController@index']); 
    Route::resource('vehicle-color', 'VehicleColorController', ['names' => ['update' => 'admin.vehicle-color.edit', 'store' => 'admin.vehicle-color.create']]);
});

