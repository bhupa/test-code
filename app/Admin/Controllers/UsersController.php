<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('email', __('Email'));
        $grid->column('country_code', __('Country code'));
        $grid->column('phone', __('Phone'));
        $grid->column('password', __('Password'));
        $grid->column('google_id', __('Google id'));
        $grid->column('facebook_id', __('Facebook id'));
        $grid->column('apple_id', __('Apple id'));
        $grid->column('account_verified_at', __('Account verified at'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('device_token', __('Device token'));
        $grid->column('verification_token', __('Verification token'));
        $grid->column('user_type', __('User type'));
        $grid->column('status', __('Status'));
        $grid->column('remember_token', __('Remember token'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('email', __('Email'));
        $show->field('country_code', __('Country code'));
        $show->field('phone', __('Phone'));
        $show->field('password', __('Password'));
        $show->field('google_id', __('Google id'));
        $show->field('facebook_id', __('Facebook id'));
        $show->field('apple_id', __('Apple id'));
        $show->field('account_verified_at', __('Account verified at'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('device_token', __('Device token'));
        $show->field('verification_token', __('Verification token'));
        $show->field('user_type', __('User type'));
        $show->field('status', __('Status'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());

        $form->email('email', __('Email'));
        $form->number('country_code', __('Country code'));
        $form->phonenumber('phone', __('Phone'));
        $form->password('password', __('Password'));
        $form->text('google_id', __('Google id'));
        $form->text('facebook_id', __('Facebook id'));
        $form->text('apple_id', __('Apple id'));
        $form->datetime('account_verified_at', __('Account verified at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->text('device_token', __('Device token'));
        $form->text('verification_token', __('Verification token'));
        $form->number('user_type', __('User type'));
        $form->number('status', __('Status'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
