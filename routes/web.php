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

// Route::get('/', function () {
//     return view('welcome');
// });


// routes for frontend
// home page
Route::get('/','IndexController@index');

// category/listing page
Route::get('/products/{url}','ProductsController@products');

// product details route
Route::get('/product/{id}','ProductsController@product');

// route for cart
Route::match(['get','post'],'/cart/add_to_cart','ProductsController@add_to_cart');
Route::match(['get','post'],'/cart/view_cart','ProductsController@view_cart');
/*delete product from cart*/
Route::get('/cart/delete_cart/{id}','ProductsController@delete_cart');

/*update product quantity from cart*/
Route::get('/cart/update_cart_quantity/{id}/{quantity}','ProductsController@update_cart_quantity');

//get product attribute price (ajax route)
Route::get('get_product_price','ProductsController@getProductPrice')->name('ajax.getProductPrice');

/*apply cuppon from cart page*/
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');




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
	Route::get('/admin/delete_category/{id}','CategoryController@delete_category');

	//products route
	Route::match(['get','post'],'/admin/add_product','ProductsController@add_product');
	Route::get('/admin/view_products', 'ProductsController@view_products');
	Route::match(['get','post'],'/admin/edit_product/{id}','ProductsController@edit_product');
	Route::get('/admin/delete_product_image/{id}','ProductsController@delete_product_image');
	Route::get('/admin/delete_product/{id}','ProductsController@delete_product');

	//product attributes
	Route::match(['get','post'],'/admin/add_attributes/{id}','ProductsController@add_attributes');
	Route::match(['get','post'],'/admin/edit_attributes/{id}','ProductsController@edit_attributes');
	Route::get('/admin/delete_attribute/{id}','ProductsController@delete_attribute');
	Route::match(['get','post'],'/admin/add_alternate_images/{id}','ProductsController@add_alternate_images');
	Route::get('/admin/delete_alternate_image/{id}','ProductsController@delete_alternate_image');

	//coupon routes
	Route::match(['get','post'],'/admin/add_coupon','CouponsController@add_coupon');
	Route::get('/admin/view_coupons', 'CouponsController@view_coupons');
	Route::match(['get','post'],'/admin/edit_coupon/{id}','CouponsController@edit_coupon');
	Route::get('/admin/delete_coupon/{id}','CouponsController@delete_coupon');


	//banner routes
	Route::match(['get','post'],'/admin/add_banner','BannersController@add_banner');
	Route::get('/admin/view_banners', 'BannersController@view_banners');
	Route::match(['get','post'],'/admin/edit_banner/{id}','BannersController@edit_banner');
	Route::get('/admin/delete_banner_image/{id}','BannersController@delete_banner_image');
	Route::get('/admin/delete_banner/{id}','BannersController@delete_banner');
});

Route::get('/logout','AdminController@logout');
