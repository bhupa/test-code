<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data =[
            ['name'=>'Nursing','status'=>1],
            ['name'=>'Building cleaning','status'=>1],
            ['name'=>'Sokeizai industry','status'=>1],
            ['name'=>'Industrial machinery industry','status'=>1],
            ['name'=>'Electrial and electronic information','status'=>1],
            
         ];
        
        DB::table('job_category')->insert($data);
    }
}
