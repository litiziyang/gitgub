<?php

namespace App\Providers;

use App\Activity;
use App\Banner;
use App\Cart;
use App\Category;
use App\Comment;
use App\Commodity;
use App\OrderGood;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\CommodityService;
use App\Services\Implement\AddressServiceImpl;
use App\Services\Implement\CartServiceImpl;
use App\Services\Implement\CommodityServiceImpl;
use App\Services\Implement\OrderServiceImpl;
use App\Services\Implement\UserServiceImpl;
use App\Services\OrderService;
use App\Services\UserService;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AddressService::class, AddressServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(OrderService::class, OrderServiceImpl::class);
        $this->app->bind(CommodityService::class, CommodityServiceImpl::class);
        $this->app->bind(CartService::class, CartServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            // 'commodity' => Commodity::class,
            'comment'   => Comment::class,
            'activity'  => Activity::class,
            'banner'    => Banner::class,
            'user'      => User::class,
            'commodity' => Commodity::class,
            'category'  => Category::class,
            'cart'      => Cart::class,
            'orderGood' => OrderGood::class,
        ]);
        \Schema::defaultStringLength(191);
    }
}
