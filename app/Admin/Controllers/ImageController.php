<?php

namespace App\Admin\Controllers;

use App\Image;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;

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

        $type = request()->type;
        $id   = request()->image_id;
        $tag  = request()->tag;
        if ($type != null && $id != null) {
            $grid->model()->where('image_type', $type)->where('image_id', $id);
        }
        if ($tag != null) {
            $grid->model()->where('tag', $tag);
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
        $image_id   = request()->image_id;
        $tag        = request()->tag;

        $form->hidden('image_id')->value($image_id);
        $form->hidden('image_type')->value($image_type);
        $form->hidden('tag')->value($tag);

        $form->image('url')->uniqueName();

        $form->submitted(function ($form) use ($image_type, $image_id, $tag) {
            if ($image_type == null || $image_id == null || $tag == null) {
                $error = new MessageBag([
                    'title'   => '错误',
                    'message' => '关键参数缺失，请从商品页进入',
                ]);

                return back()->with(compact('error'));
            }
        });
        return $form;
    }
}
