<?php

use Encore\Admin\Auth\Database\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 8,
            'title'     => '首页轮播图',
            'icon'      => 'fa-bars',
            'uri'       => '/banner'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => '商品',
            'icon'      => 'fa-bars',
            'uri'       => '/commodity'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 10,
            'title'     => '分类',
            'icon'      => 'fa-bars',
            'uri'       => '/category'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 11,
            'title'     => '活动',
            'icon'      => 'fa-bars',
            'uri'       => '/activity'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 12,
            'title'     => '评论',
            'icon'      => 'fa-bars',
            'uri'       => '/comment'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 13,
            'title'     => '交易',
            'icon'      => 'fa-bars',
            'uri'       => '/transaction'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 14,
            'title'     => '订单',
            'icon'      => 'fa-bars',
            'uri'       => '/order'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 15,
            'title'     => '首页轮播图',
            'icon'      => 'fa-bars',
            'uri'       => '/user'
        ]);
        Menu::query()->firstOrCreate([
            'parent_id' => 0,
            'order'     => 16,
            'title'     => '系统日志',
            'icon'      => 'fa-database',
            'uri'       => '/logs'
        ]);
    }
}
