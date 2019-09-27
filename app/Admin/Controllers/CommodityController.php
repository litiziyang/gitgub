<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Image\Commodity\Banner;
use App\Admin\Actions\Image\Commodity\BannerShow;
use App\Admin\Actions\Image\Commodity\Details;
use App\Admin\Actions\Image\Commodity\DetailsShow;
use App\Category;
use App\Commodity;
use App\Image;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommodityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Commodity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Commodity);

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('category_id', __('Category id'));
        $grid->column('price', __('Price'));
        $grid->column('reward', __('Reward'));
        $grid->column('count_sales', __('Count sales'));
        $grid->column('count_comment', __('Count comment'));
        $grid->column('count_view', __('Count view'));
        $grid->column('count_stack', __('Count stack'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->actions(function ($actions) {
            $actions->add(new Banner);
            $actions->add(new BannerShow);
            $actions->add(new Details);
            $actions->add(new DetailsShow);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Commodity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('category_id', __('Category id'));
        $show->field('price', __('Price'));
        $show->field('reward', __('Reward'));
        $show->field('count_sales', __('Count sales'));
        $show->field('count_comment', __('Count comment'));
        $show->field('count_view', __('Count view'));
        $show->field('count_stack', __('Count stack'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Commodity);

        $form->text('title', __('Title'));

        $categories = Category::all();
        $options    = [];
        foreach (($categories) as $category) {
            $options[$category->id] = $category->name;
        }
        $form->select('category_id', __('Category'))->options($options);

        $form->decimal('price', __('Price'));
        $form->decimal('reward', __('Reward'));

        if (!$form->isEditing()) {
            $form->multipleImage('banners', '展示图片')->uniqueName();
            $form->multipleImage('details', '详情图片')->uniqueName();
        }

        $form->saved(function (Form $form) {
            $banners = $form->model()->banners;
            $details = $form->model()->details;
            foreach ($banners as $key => $url) {
                Image::create([
                    'url'        => $url,
                    'image_type' => 'commodity_banner',
                    'image_id'   => $form->model()->id,
                ]);
            }
            foreach ($details as $key => $url) {
                Image::create([
                    'url'        => $url,
                    'image_type' => 'commodity_detail',
                    'image_id'   => $form->model()->id,
                ]);
            }
        });

        return $form;
    }
}
