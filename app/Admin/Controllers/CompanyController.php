<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Company;

class CompanyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Company';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Company());

        $grid->column('id', __('Id'));
        $grid->column('company_name', __('Company name'));
        $grid->column('about_company', __('About company'));
        $grid->column('address', __('Address'));
        $grid->column('logo', __('Logo'))->image(url('/').'storage', 100, 100);
        $grid->column('status', __('Status'));
        $grid->column('user.email', __('User'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Company::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('company_name', __('Company name'));
        $show->field('about_company', __('About company'));
        $show->field('address', __('Address'));
        $show->field('logo', __('Logo'));
        $show->field('status', __('Status'));
        $show->field('user_id', __('User id'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Company());

        $form->text('company_name', __('Company name'));
        $form->textarea('about_company', __('About company'));
        $form->text('address', __('Address'));
        $form->text('logo', __('Logo'));
        $form->number('status', __('Status'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
