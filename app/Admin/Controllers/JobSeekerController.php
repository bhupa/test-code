<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Jobseeker;

class JobSeekerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jobseeker';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jobseeker());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('image', __('Image'));
        $grid->column('birthday', __('Birthday'));
        $grid->column('country', __('Country'));
        $grid->column('current_country', __('Current country'));
        $grid->column('gender', __('Gender'));
        $grid->column('occupation', __('Occupation'));
        $grid->column('experience', __('Experience'));
        $grid->column('japanese_level', __('Japanese level'));
        $grid->column('about', __('About'));
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
        $show = new Show(Jobseeker::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('image', __('Image'));
        $show->field('birthday', __('Birthday'));
        $show->field('country', __('Country'));
        $show->field('current_country', __('Current country'));
        $show->field('gender', __('Gender'));
        $show->field('occupation', __('Occupation'));
        $show->field('experience', __('Experience'));
        $show->field('japanese_level', __('Japanese level'));
        $show->field('about', __('About'));
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
        $form = new Form(new Jobseeker());

        $form->number('user_id', __('User id'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->image('image', __('Image'));
        $form->date('birthday', __('Birthday'))->default(date('Y-m-d'));
        $form->text('country', __('Country'));
        $form->text('current_country', __('Current country'));
        $form->text('gender', __('Gender'));
        $form->text('occupation', __('Occupation'));
        $form->text('experience', __('Experience'));
        $form->text('japanese_level', __('Japanese level'));
        $form->textarea('about', __('About'));

        return $form;
    }
}
