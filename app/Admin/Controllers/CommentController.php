<?php

namespace App\Admin\Controllers;

use App\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment);

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'));
        $grid->column('star', __('Star'));
        $grid->column('user_id', __('User id'));
        $grid->column('comment_type', __('Comment type'));
        $grid->column('comment_id', __('Comment id'));
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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'));
        $show->field('star', __('Star'));
        $show->field('user_id', __('User id'));
        $show->field('comment_type', __('Comment type'));
        $show->field('comment_id', __('Comment id'));
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
        $form = new Form(new Comment);

        $form->text('content', __('Content'));
        $form->text('star', __('Star'));
        $form->number('user_id', __('User id'));
        $form->text('comment_type', __('Comment type'));
        $form->number('comment_id', __('Comment id'));

        return $form;
    }
}
