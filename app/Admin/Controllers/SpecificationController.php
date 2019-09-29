<?php

namespace App\Admin\Controllers;

use App\Commodity;
use App\Specification;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;

class SpecificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Specification';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Specification);

        $commodity_id = request()->commodity_id;
        if ($commodity_id != null) {
            $grid->model()->where('commodity_id', $commodity_id);
        }
        $grid->column('id', __('Id'));
        // $grid->column('commodity_id', __('Commodity id'));
        $grid->column('name', __('Name'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->actions(function ($actions) {
            // $actions->disableDelete();
            // $actions->disableEdit();
            // $actions->disableView();
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
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
        $show = new Show(Specification::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('commodity_id', __('Commodity id'));
        $show->field('name', __('Name'));
        $show->field('quantity', __('Quantity'));
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
        $form = new Form(new Specification);

        $commodity_id = request()->commodity_id;
        $form->hidden('commodity_id')->value($commodity_id);

        $form->text('name', __('Name'));
        $form->number('quantity', __('Quantity'));

        $form->submitted(function ($form) use ($commodity_id) {
            if ($commodity_id == null) {
                $error = new MessageBag([
                    'title'   => '错误',
                    'message' => '关键参数缺失，请从商品页进入',
                ]);

                return back()->with(compact('error'));
            }
        });
        $form->saved(function ($form) {
            $form->model()->commodity->countSpecification();
        });

        return $form;
    }
}
