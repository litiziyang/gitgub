<?php

namespace App\Admin\Controllers;

use App\Image;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Image';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Image);

        $type     = request()->type;
        $image_id = request()->commodity_id;
        if ($type != null && $image_id != null) {
            $grid->model()->where('image_type', $type)->where('image_id', $image_id);
        }

        $grid->column('id', __('Id'));
        $grid->column('url', __('Url'));
        $grid->column('image_type', __('Image type'));
        $grid->column('image_id', __('Image id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Image::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('url', __('Url'));
        $show->field('image_type', __('Image type'));
        $show->field('image_id', __('Image id'));
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
        $form = new Form(new Image);

        $image_type = request()->type;
        $image_id   = request()->commodity_id;

        $form->text('image_id')->value($image_id);
        $form->text('image_type')->value($image_type);
        $form->image('url')->uniqueName();

        return $form;
    }
}
