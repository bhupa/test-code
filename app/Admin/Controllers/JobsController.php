<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Jobs;

class JobsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jobs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jobs());

        $grid->column('id', __('Id'));
        $grid->column('job_title', __('Job title'));
        $grid->column('job_location', __('Job location'));
        $grid->column('salary_from', __('Salary from'));
        $grid->column('salary_to', __('Salary to'));
        $grid->column('working_hours', __('Working hours'));
        $grid->column('break_time', __('Break time'));
        $grid->column('holidays', __('Holidays'));
        $grid->column('vacation', __('Vacation'));
        $grid->column('age_from', __('Age from'));
        $grid->column('age_to', __('Age to'));
        $grid->column('gender', __('Gender'));
        $grid->column('experience', __('Experience'));
        $grid->column('japanese_level', __('Japanese level'));
        $grid->column('required_skills', __('Required skills'));
        $grid->column('published', __('Published'));
        $grid->column('from_when', __('From when'));
        $grid->column('experience_required', __('Experience required'));
        $grid->column('pay_raise', __('Pay raise'));
        $grid->column('training', __('Training'));
        $grid->column('education', __('Education'));
        $grid->column('women_preferred', __('Women preferred'));
        $grid->column('men_preferred', __('Men preferred'));
        $grid->column('urgent_recruitment', __('Urgent recruitment'));
        $grid->column('social_insurance', __('Social insurance'));
        $grid->column('english_required', __('English required'));
        $grid->column('accommodation', __('Accommodation'));
        $grid->column('five_days_working', __('Five days working'));
        $grid->column('uniform_provided', __('Uniform provided'));
        $grid->column('station_chika', __('Station chika'));
        $grid->column('skill_up', __('Skill up'));
        $grid->column('big_company', __('Big company'));
        $grid->column('employer_status', __('Employer status'));
        $grid->column('temporary_staff', __('Temporary staff'));
        $grid->column('status', __('Status'));
        $grid->column('user_id', __('User id'));
        $grid->column('occupation', __('Occupation'));
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
        $show = new Show(Jobs::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('job_title', __('Job title'));
        $show->field('job_location', __('Job location'));
        $show->field('salary_from', __('Salary from'));
        $show->field('salary_to', __('Salary to'));
        $show->field('working_hours', __('Working hours'));
        $show->field('break_time', __('Break time'));
        $show->field('holidays', __('Holidays'));
        $show->field('vacation', __('Vacation'));
        $show->field('age_from', __('Age from'));
        $show->field('age_to', __('Age to'));
        $show->field('gender', __('Gender'));
        $show->field('experience', __('Experience'));
        $show->field('japanese_level', __('Japanese level'));
        $show->field('required_skills', __('Required skills'));
        $show->field('published', __('Published'));
        $show->field('from_when', __('From when'));
        $show->field('experience_required', __('Experience required'));
        $show->field('pay_raise', __('Pay raise'));
        $show->field('training', __('Training'));
        $show->field('education', __('Education'));
        $show->field('women_preferred', __('Women preferred'));
        $show->field('men_preferred', __('Men preferred'));
        $show->field('urgent_recruitment', __('Urgent recruitment'));
        $show->field('social_insurance', __('Social insurance'));
        $show->field('english_required', __('English required'));
        $show->field('accommodation', __('Accommodation'));
        $show->field('five_days_working', __('Five days working'));
        $show->field('uniform_provided', __('Uniform provided'));
        $show->field('station_chika', __('Station chika'));
        $show->field('skill_up', __('Skill up'));
        $show->field('big_company', __('Big company'));
        $show->field('employer_status', __('Employer status'));
        $show->field('temporary_staff', __('Temporary staff'));
        $show->field('status', __('Status'));
        $show->field('user_id', __('User id'));
        $show->field('occupation', __('Occupation'));
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
        $form = new Form(new Jobs());

        $form->textarea('job_title', __('Job title'));
        $form->number('job_location', __('Job location'));
        $form->decimal('salary_from', __('Salary from'));
        $form->decimal('salary_to', __('Salary to'));
        $form->number('working_hours', __('Working hours'));
        $form->number('break_time', __('Break time'));
        $form->text('holidays', __('Holidays'));
        $form->text('vacation', __('Vacation'));
        $form->number('age_from', __('Age from'));
        $form->number('age_to', __('Age to'));
        $form->number('gender', __('Gender'));
        $form->number('experience', __('Experience'));
        $form->number('japanese_level', __('Japanese level'));
        $form->textarea('required_skills', __('Required skills'));
        $form->datetime('published', __('Published'))->default(date('Y-m-d H:i:s'));
        $form->datetime('from_when', __('From when'))->default(date('Y-m-d H:i:s'));
        $form->switch('experience_required', __('Experience required'));
        $form->switch('pay_raise', __('Pay raise'));
        $form->switch('training', __('Training'));
        $form->switch('education', __('Education'));
        $form->switch('women_preferred', __('Women preferred'));
        $form->switch('men_preferred', __('Men preferred'));
        $form->switch('urgent_recruitment', __('Urgent recruitment'));
        $form->switch('social_insurance', __('Social insurance'));
        $form->switch('english_required', __('English required'));
        $form->switch('accommodation', __('Accommodation'));
        $form->switch('five_days_working', __('Five days working'));
        $form->switch('uniform_provided', __('Uniform provided'));
        $form->switch('station_chika', __('Station chika'));
        $form->switch('skill_up', __('Skill up'));
        $form->switch('big_company', __('Big company'));
        $form->switch('employer_status', __('Employer status'));
        $form->switch('temporary_staff', __('Temporary staff'));
        $form->number('status', __('Status'));
        $form->number('user_id', __('User id'));
        $form->number('occupation', __('Occupation'));

        return $form;
    }
}
