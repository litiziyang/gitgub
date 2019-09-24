<?php

namespace App\Admin\Controllers;

use App\Commodity;
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
        $form->number('category_id', __('Category id'));
        $form->decimal('price', __('Price'));
        $form->decimal('reward', __('Reward'));
        $form->number('count_sales', __('Count sales'));
        $form->number('count_comment', __('Count comment'));
        $form->number('count_view', __('Count view'));
        $form->number('count_stack', __('Count stack'));

        return $form;
    }
}
