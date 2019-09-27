<?php

namespace App\Admin\Controllers;

use App\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);
        $grid->column('target', __('Target'));
        $grid->column('image.url', __('Url'))->image();
        $grid->column('level', __('Level'));
        $grid->column('color', __('Color'))->display(function ($color) {
            return '<div style="width:35px;height:35px;padding:5px;background:' .$color .';"></div>';
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
        $show = new Show(Banner::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner);

        $form->image('image.url')->uniqueName();
        $form->text('target', '点击跳转网址');
        $form->number('level', __('Level'));
        $form->color('color', __('Color'));
        return $form;
    }
}
