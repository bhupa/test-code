<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
            'name' => 'Monthly',
            'slug' => 'monthly',
             'stripe_plan' => 'prod_Ofk0qyrL8FJCKy',
            'price' => 10,
            'description' => 'Monthly',
            ],
            [
                'name' => 'Quarterly',
                'slug' => 'quarterly',
                 'stripe_plan' => 'prod_Ofk3TI6aYNs8ye',
                'price' => 30,
                'description' => 'quarterly',
             ],
             [
                    'name' => 'Half Yearly',
                    'slug' => 'half-yearly',
                     'stripe_plan' => 'prod_Ofk5nTIzOKpiJk',
                    'price' => 60,
                    'description' => 'Half Yearly',
             ],
         ];

        Plan::insert($data);
    }
}
