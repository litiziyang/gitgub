<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Commodity\Banner;
use App\Admin\Actions\Commodity\BannerShow;
use App\Admin\Actions\Commodity\Details;
use App\Admin\Actions\Commodity\DetailsShow;
use App\Admin\Actions\Commodity\Specification;
use App\Admin\Actions\Commodity\SpecificationShow;
use App\Category;
use App\Commodity;
use App\Image;
use App\Specification as AppSpecification;
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
        $grid->column('category.name', __('Category'));
        $grid->column('price', __('Price'));
        $grid->column('reward', __('Reward'));
        $grid->column('count_sales', __('Count sales'));
        // $grid->column('count_comment', __('Count comment'));
        // $grid->column('count_view', __('Count view'));
        $grid->column('count_stack', __('Count stack'));

        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->add(new Banner);
            $actions->add(new BannerShow);
            $actions->add(new Details);
            $actions->add(new DetailsShow);
            // $actions->add(new Specification);
            // $actions->add(new SpecificationShow);
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

        $commodity = Commodity::with('bannerImages')
            ->with('detailImages')
            ->findOrFail($id);
        $bannerImages = $commodity->bannerImages;
        $i            = 0;
        foreach ($bannerImages as $image) {
            $i++;
            $show->field('展示图' . $i)->as(function () use ($image) {
                return $image->url;
            })->image();
        }

        $detailImages = $commodity->detailImages;
        $i            = 0;
        foreach ($detailImages as $image) {
            $i++;
            $show->field('详情图' . $i)->as(function () use ($image) {
                return $image->url;
            })->image();
        }

        // $specifications = $commodity->specifications;
        // foreach($specifications as $specification){
        //     $show->field($specification->name)->as(function() use ($specification){
        //         return $specification->quantity;
        //     });
        // }

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

        $form->text('title', __('Title'))->required();

        $categories = Category::all();
        $options    = [];
        foreach ($categories as $category) {
            if(sizeof($category->child) == 0){
                $options[$category->id] = $category->name;
            }
        }
        $form->select('category_id', __('Category'))->options($options)->required();

        $form->decimal('price', __('Price'))->required();
        $form->decimal('reward', __('Reward'))->required();
        $form->number('count_stack',__('Count stack'))->required();

        if (!$form->isEditing()) {
            $form->multipleImage('banners', '展示图片')->uniqueName();
            $form->multipleImage('details', '详情图片')->uniqueName();
            // $form->table('specification', function ($table) {
            //     $table->text('name');
            //     $table->text('quantity');
            // });
        }

        $form->saved(function (Form $form) {
            $banners        = $form->model()->banners;
            $details        = $form->model()->details;
            // $specifications = $form->model()->specificationArray;
            // if ($specifications != null) {
            //     foreach ($specifications as $specification) {
            //         AppSpecification::create([
            //             'name'         => $specification['name'],
            //             'quantity'     => $specification['quantity'],
            //             'commodity_id' => $form->model()->id,
            //         ]);
            //     }
            //     $form->model()->countSpecification();
            // }

            if ($banners != null) {
                foreach ($banners as $key => $url) {
                    Image::create([
                        'url'        => $url,
                        'image_type' => 'commodity_banner',
                        'image_id'   => $form->model()->id,
                    ]);
                }
            }
            if ($details != null) {
                foreach ($details as $key => $url) {
                    Image::create([
                        'url'        => $url,
                        'image_type' => 'commodity_detail',
                        'image_id'   => $form->model()->id,
                    ]);
                }
            }
        });

        return $form;
    }
}
