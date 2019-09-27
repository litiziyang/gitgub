<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('/activity', 'ActivityController');
    $router->resource('/banner', 'BannerController');
    $router->resource('/category', 'CategoryController');
    $router->resource('/comment', 'CommentController');
    $router->resource('/coupon', 'CouponController');
    $router->resource('/order', 'OrderController');
    $router->resource('/transaction', 'TransactionController');
    $router->resource('/user', 'UserController');
    $router->resource('/commodity', 'CommodityController');
    $router->resource('/image', 'ImageController');
});
