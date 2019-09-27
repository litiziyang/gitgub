<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('phone', __('Phone'));
        $grid->column('integral', __('Integral'));
        $grid->column('balance', __('Balance'));
        $grid->column('member_type', __('Member type'));
        $grid->column('open_id', __('Open id'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('phone', __('Phone'));
        $show->field('integral', __('Integral'));
        $show->field('balance', __('Balance'));
        $show->field('member_type', __('Member type'));
        $show->field('open_id', __('Open id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->number('integral', __('Integral'));
        $form->decimal('balance', __('Balance'))->default(0.00);
        $form->text('member_type', __('Member type'));
        $form->text('open_id', __('Open id'));

        return $form;
    }
}
