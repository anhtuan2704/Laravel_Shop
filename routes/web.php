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
//frontend
Route::get('/', 'HomeController@index');

Route::get('/trang-chu', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search');

//Danh muc san pham
Route::get('/danh-muc-san-pham/{slug_category_product}', 'CategoryProduct@show_category');
Route::get('/thuong-hieu-san-pham/{brand_id}', 'BrandProduct@show_brand');
Route::get('/chi-tiet-san-pham/{product_id}', 'ProductController@details_product');



//backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::get('/logout', 'AdminController@log_out');
Route::post('/admin-dashboard', 'AdminController@dashboard');

//Coupon
Route::get('/insert-coupon', 'CouponController@insert_coupon');
Route::get('/delete-coupon/{coupon_id}', 'CouponController@delete_coupon');
Route::post('/insert-coupon-code', 'CouponController@insert_coupon_code');
Route::get('/list-coupon', 'CouponController@list_coupon');


//Category Product
Route::get('/add-category-product', 'CategoryProduct@addCategory');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@editCategory');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@deteleCategory');
Route::get('/all-category-product', 'CategoryProduct@allCategory');


Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');


Route::post('/save-category-product', 'CategoryProduct@saveCategory');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@updateCategory');

//Brand Product
Route::get('/add-brand', 'BrandProduct@addBrand');
Route::get('/edit-brand/{brand_id}', 'BrandProduct@editBrand');
Route::get('/delete-brand/{brand_id}', 'BrandProduct@deteleBrand');
Route::get('/all-brand', 'BrandProduct@allBrand');


Route::get('/unactive-brand/{brand_id}', 'BrandProduct@unactive_brand');
Route::get('/active-brand/{brand_id}', 'BrandProduct@active_brand');


Route::post('/save-brand', 'BrandProduct@saveBrand');
Route::post('/update-brand/{brand_id}', 'BrandProduct@updateBrand');

//Product
Route::get('/add-product', 'ProductController@addproduct');
Route::get('/edit-product/{product_id}', 'ProductController@editproduct');
Route::get('/delete-product/{product_id}', 'ProductController@deteleproduct');
Route::get('/all-product', 'ProductController@allproduct');


Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');


Route::post('/save-product', 'ProductController@saveproduct');
Route::post('/update-product/{product_id}', 'ProductController@updateproduct');

//Cart
Route::post('/save-cart', 'CartController@savecart');
Route::post('/update-cart-quatity', 'CartController@update_cart_quatity');
Route::post('/update-cart', 'CartController@update_cart');
Route::post('/add-cart-ajax', 'CartController@add_cart_ajax');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/gio-hang', 'CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');
Route::get('/delete-cart/{session_id}', 'CartController@delete_cart');
Route::get('/del-all-product', 'CartController@del_all_product');

//coupon
Route::post('/check-coupon', 'CartController@check_coupon');



//check-out

Route::get('/login-check-out', 'CheckoutController@login_check_out');
Route::get('/logout-check-out', 'CheckoutController@logout_check_out');
Route::get('/checkout', 'CheckoutController@check_out');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/order-place', 'CheckoutController@order_place');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::post('/select-delivery-home', 'CheckoutController@select_delivery_home');
Route::post('/calculate-fee', 'CheckoutController@calculate_fee');
Route::get('/del-fee', 'CheckoutController@del_fee');

Route::get('/manager-order', 'OrderController@manager_order');
Route::get('/view-order/{order_code}', 'OrderController@view_order');
Route::post('/conform-order', 'CheckoutController@conform_order');


//Send Mail
Route::get('/send-mail', 'HomeController@send_mail');

//Delivery

Route::get('/delivery', 'DeliveryController@delivery');
Route::post('/select-delivery', 'DeliveryController@select_delivery');
Route::post('/insert-delivery', 'DeliveryController@insert_delivery');
Route::post('/select-feeship', 'DeliveryController@select_feeship');
Route::post('/update-delivery', 'DeliveryController@update_delivery');

//slider
Route::get('/manager-slider', 'SliderController@manager_slider');
Route::get('/add-slider', 'SliderController@add_slider');
Route::post('/insert-slider', 'SliderController@insert_slider');

















