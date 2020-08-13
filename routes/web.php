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

Auth::routes();

Route::get('/', function () {
    return redirect('login');
});

Route::get('customer/register', 'CustomerController@register'); 
Route::post('customer/register', 'CustomerController@create'); 

Route::group(['middleware' => ['auth:web', 'menu_web']], function () {

	Route::get('home', 'IndexController@index');

	Route::group(['prefix' => 'customer'], function () {
		Route::get('mydata', 'CustomerController@mydata')->name('customer.mydata');
		Route::put('saveMydata', 'CustomerController@saveMydata');
		
		Route::get('family', 'CustomerController@family')->name('customer.family');
		Route::get('work', 'CustomerController@work')->name('customer.work');
	});
});


