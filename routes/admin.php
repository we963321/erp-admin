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

Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

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

    //儀表版
    Route::get('/', ['as' => 'index', 'uses' => function () {
        return redirect('/admin/log-viewer');
    }]);

    //權限管理
    Route::get('permission/{cid}/create', ['as' => 'permission.create', 'uses' => 'PermissionController@create']);
    Route::get('permission/manage', ['as' => 'permission.manage', 'uses' => 'PermissionController@index']);
    Route::get('permission/{cid?}', ['as' => 'permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'permission.index', 'uses' => 'PermissionController@index']); //查詢
    Route::resource('permission', 'PermissionController', ['names' => ['update' => 'permission.edit', 'store' => 'permission.create']]);


    //角色管理
    Route::get('role/index', ['as' => 'role.index', 'uses' => 'RoleController@index']);
    Route::post('role/index', ['as' => 'role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController', ['names' => ['update' => 'role.edit', 'store' => 'role.create']]);


    //用戶管理
    Route::get('user/index', ['as' => 'user.index', 'uses' => 'UserController@index']);
    Route::post('user/index', ['as' => 'user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController', ['names' => ['update' => 'user.edit', 'store' => 'user.create']]);

    //店別管理
    Route::get('store/index', ['as' => 'store.index', 'uses' => 'StoreController@index']);
    Route::post('store/index', ['as' => 'store.index', 'uses' => 'StoreController@index']);
    Route::resource('store', 'StoreController', ['names' => ['update' => 'store.edit', 'store' => 'store.create']]);

    //客戶管理
    Route::get('customer/{customer}/cars', 'CustomerController@cars')->name('customer.cars');
    Route::put('customer/{customer}/cars', 'CustomerController@carsUpdate')->name('customer.cars.update');
    Route::get('customer/{customer}/projects', 'CustomerController@projects')->name('customer.projects');
    Route::put('customer/{customer}/projects', 'CustomerController@projectsUpdate')->name('customer.projects.update');
    Route::get('customer/index', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
    Route::post('customer/index', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
    Route::resource('customer', 'CustomerController', ['names' => ['update' => 'customer.edit', 'store' => 'customer.create']]);

    //縣市
    Route::get('counties/index', ['as' => 'counties.index', 'uses' => 'CountiesController@index']);
    Route::post('counties/index', ['as' => 'counties.datatable', 'uses' => 'CountiesController@index']);
    Route::resource('counties', 'CountiesController', ['names' => ['update' => 'counties.edit', 'store' => 'counties.create']]);

    //鄉鎮區
    Route::get('town/index', ['as' => 'town.index', 'uses' => 'TownController@index']);
    Route::post('town/index', ['as' => 'town.index', 'uses' => 'TownController@index']);
    Route::resource('town', 'TownController', ['names' => ['update' => 'town.edit', 'store' => 'town.create']]);

    //居住社區
    Route::get('community/index', ['as' => 'community.index', 'uses' => 'CommunityController@index']);
    Route::post('community/index', ['as' => 'community.index', 'uses' => 'CommunityController@index']);
    Route::resource('community', 'CommunityController', ['names' => ['update' => 'community.edit', 'store' => 'community.create']]);

    //會員種類
    Route::get('customer-category/index', ['as' => 'customer-category.index', 'uses' => 'CustomerCategoryController@index']);
    Route::post('customer-category/index', ['as' => 'customer-category.index', 'uses' => 'CustomerCategoryController@index']);
    Route::resource('customer-category', 'CustomerCategoryController', ['names' => ['update' => 'customer-category.edit', 'store' => 'customer-category.create']]);

    //專屬服務
    Route::get('customer-service/index', ['as' => 'customer-service.index', 'uses' => 'CustomerServiceController@index']);
    Route::post('customer-service/index', ['as' => 'customer-service.index', 'uses' => 'CustomerServiceController@index']);
    Route::resource('customer-service', 'CustomerServiceController', ['names' => ['update' => 'customer-service.edit', 'store' => 'customer-service.create']]);

    //專案資料
    Route::get('customer-project/index', ['as' => 'customer-project.index', 'uses' => 'CustomerProjectController@index']);
    Route::post('customer-project/index', ['as' => 'customer-project.datatable', 'uses' => 'CustomerProjectController@index']);
    Route::resource('customer-project', 'CustomerProjectController');

    //產品類別
    Route::get('product-category/index', ['as' => 'product-category.index', 'uses' => 'ProductCategoryController@index']);
    Route::post('product-category/index', ['as' => 'product-category.index', 'uses' => 'ProductCategoryController@index']);
    Route::resource('product-category', 'ProductCategoryController', ['names' => ['update' => 'product-category.edit', 'store' => 'product-category.create']]);

    //產品資料
    Route::get('product/index', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::post('product/index', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::resource('product', 'ProductController', ['names' => ['update' => 'product.edit', 'store' => 'product.create']]);

    //行業別
    Route::get('industry/index', ['as' => 'industry.index', 'uses' => 'IndustryController@index']);
    Route::post('industry/index', ['as' => 'industry.index', 'uses' => 'IndustryController@index']);
    Route::resource('industry', 'IndustryController', ['names' => ['update' => 'industry.edit', 'store' => 'industry.create']]);

    //休閒娛樂
    Route::get('entertainment/index', ['as' => 'entertainment.index', 'uses' => 'EntertainmentController@index']);
    Route::post('entertainment/index', ['as' => 'entertainment.index', 'uses' => 'EntertainmentController@index']);
    Route::resource('entertainment', 'EntertainmentController', ['names' => ['update' => 'entertainment.edit', 'store' => 'entertainment.create']]);

    //旅行模式
    Route::get('tour/index', ['as' => 'tour.index', 'uses' => 'TourController@index']);
    Route::post('tour/index', ['as' => 'tour.index', 'uses' => 'TourController@index']);
    Route::resource('tour', 'TourController', ['names' => ['update' => 'tour.edit', 'store' => 'tour.create']]);

    //收藏嗜好
    Route::get('hobby/index', ['as' => 'hobby.index', 'uses' => 'HobbyController@index']);
    Route::post('hobby/index', ['as' => 'hobby.index', 'uses' => 'HobbyController@index']);
    Route::resource('hobby', 'HobbyController', ['names' => ['update' => 'hobby.edit', 'store' => 'hobby.create']]);

    //車輛品牌
    Route::get('vehicle-brand/index', ['as' => 'vehicle-brand.index', 'uses' => 'VehicleBrandController@index']);
    Route::post('vehicle-brand/index', ['as' => 'vehicle-brand.index', 'uses' => 'VehicleBrandController@index']);
    Route::resource('vehicle-brand', 'VehicleBrandController', ['names' => ['update' => 'vehicle-brand.edit', 'store' => 'vehicle-brand.create']]);

    //品牌車系
    Route::get('brand-series/index', ['as' => 'brand-series.index', 'uses' => 'BrandSeriesController@index']);
    Route::post('brand-series/index', ['as' => 'brand-series.datatable', 'uses' => 'BrandSeriesController@index']);
    Route::resource('brand-series', 'BrandSeriesController');

    //車輛顏色
    Route::get('vehicle-color/index', ['as' => 'vehicle-color.index', 'uses' => 'VehicleColorController@index']);
    Route::post('vehicle-color/index', ['as' => 'vehicle-color.datatable', 'uses' => 'VehicleColorController@index']);
    Route::resource('vehicle-color', 'VehicleColorController', ['names' => ['update' => 'vehicle-color.edit', 'store' => 'vehicle-color.create']]);

    /**
     * Admin Route resources
     * 
     * resource name => controller name
     */
    $resources = [
        'customer-contacts' => 'CustomerContactsController'
    ];

    foreach ($resources as $name => $controllerName) {
        Route::get($name . '/index', ['as' => $name . '.index', 'uses' => $controllerName . '@index']);
        Route::post($name . '/index', ['as' => $name . '.datatable', 'uses' => $controllerName .  '@index']);
        Route::resource($name, $controllerName);
    }
});
