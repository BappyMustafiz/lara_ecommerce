<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// routes for admin

Route::match(['get','post'],'/admin','AdminController@login');

Route::group(['middleware' =>['auth']], function(){
	Route::get('/admin/dashboard','AdminController@dashboard');
	Route::get('/admin/settings','AdminController@settings');
	Route::get('/admin/check-pwd','AdminController@checkPassword');
	Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

	//categories route
	Route::match(['get','post'],'/admin/add_category','CategoryController@add_category');
	Route::get('/admin/view_categories', 'CategoryController@view_categories');
	Route::match(['get','post'],'/admin/edit_category/{id}','CategoryController@edit_category');
	Route::match(['get','post'],'/admin/delete_category/{id}','CategoryController@delete_category');

	//products route
	Route::match(['get','post'],'/admin/add_product','ProductsController@add_product');
	Route::get('/admin/view_products', 'ProductsController@view_products');
	Route::match(['get','post'],'/admin/edit_product/{id}','ProductsController@edit_product');
	Route::get('/admin/delete_product_image/{id}','ProductsController@delete_product_image');
	Route::get('/admin/delete_product/{id}','ProductsController@delete_product');

	//product attributes
	Route::match(['get','post'],'/admin/add_attributes/{id}','ProductsController@add_attributes');
});

Route::get('/logout','AdminController@logout');
