<?php

namespace App\Admin\Controllers;

use App\Coupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Coupon';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupon);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('expire', __('Expire'));
        $grid->column('user_id', __('User id'));
        $grid->column('offer', __('Offer'));
        $grid->column('condition', __('Condition'));
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
        $show = new Show(Coupon::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('expire', __('Expire'));
        $show->field('user_id', __('User id'));
        $show->field('offer', __('Offer'));
        $show->field('condition', __('Condition'));
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
        $form = new Form(new Coupon);

        $form->text('name', __('Name'));
        $form->datetime('expire', __('Expire'))->default(date('Y-m-d H:i:s'));
        $form->number('user_id', __('User id'));
        $form->number('offer', __('Offer'));
        $form->text('condition', __('Condition'));

        return $form;
    }
}
