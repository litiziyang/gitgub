<?php

namespace App\Admin\Controllers;

use App\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('Id'));
        $grid->column('number', __('Number'));
        $grid->column('transaction_id', __('Transaction'));
        $grid->column('user.phone', __('User'));
        $grid->column('state', __('State'))->select([
            Order::PENDING_PAYMENT => Order::getStateName(Order::PENDING_PAYMENT),
            Order::BEING_PROCESSED => Order::getStateName(Order::BEING_PROCESSED),
            Order::SHIPPED         => Order::getStateName(Order::SHIPPED),
            Order::EVALUATE        => Order::getStateName(Order::EVALUATE),
            Order::INVALID         => Order::getStateName(Order::INVALID),
            Order::COMPLETED       => Order::getStateName(Order::COMPLETED),
            Order::AFTER_SALE      => Order::getStateName(Order::AFTER_SALE),
        ]);
        $grid->column('delivery_number', '快递单号')->editable();
        $grid->column('good', '商品')->expand(function (Model $model) {
            $orderGoods = $model->orderGood->map(function (Model $good) {
                return $good->only(['id', 'title', 'pay', 'count']);
            });
            return new \Encore\Admin\Widgets\Table(['ID', '标题', '价格', '数量'], $orderGoods->toArray());
        });
        $grid->column('price', '价格');
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('number', __('Number'));
        $show->field('transaction_id', __('Transaction id'));
        $show->field('user_id', __('User id'));
        $show->field('state', __('State'))->as(function ($state) {
            return Order::getStateName($state);
        });
        $show->field('delivery_number', '快递单号');
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
        $form = new Form(new Order);

        $form->text('number', __('Number'))->disable();
        $form->select('state', __('State'))->options([
            Order::PENDING_PAYMENT => Order::getStateName(Order::PENDING_PAYMENT),
            Order::BEING_PROCESSED => Order::getStateName(Order::BEING_PROCESSED),
            Order::SHIPPED         => Order::getStateName(Order::SHIPPED),
            Order::EVALUATE        => Order::getStateName(Order::EVALUATE),
            Order::INVALID         => Order::getStateName(Order::INVALID),
            Order::COMPLETED       => Order::getStateName(Order::COMPLETED),
            Order::AFTER_SALE      => Order::getStateName(Order::AFTER_SALE),
        ]);

        return $form;
    }
}
