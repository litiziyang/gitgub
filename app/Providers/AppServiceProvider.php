<?php

namespace App\Providers;

use App\Activity;
use App\Banner;
use App\Cart;
use App\Category;
use App\Comment;
use App\Commodity;
use App\Repositories\AddressRepository;
use App\Repositories\Implement\AddressRepositoryImpl;
use App\Services\AddressService;
use App\Services\Implement\AddressServiceImpl;
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
        $this->app->bind(AddressRepository::class, AddressRepositoryImpl::class);
        $this->app->bind(AddressService::class, AddressServiceImpl::class);


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
        ]);
    }
}
