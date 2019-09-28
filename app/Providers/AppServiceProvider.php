<?php

namespace App\Providers;

use App\Activity;
use App\Banner;
use App\Comment;
use App\Commodity;
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
        //
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
            'comment'          => Comment::class,
            'activity'         => Activity::class,
            'banner'           => Banner::class,
            'user'             => User::class,
            'commodity' => Commodity::class,
        ]);
    }
}
