<?php

namespace Database\Seeders;

use App\Models\BreakTime;
use App\Models\JobCategory;
use App\Models\Locations;
use App\Models\User;
use App\Models\WorkingHour;
use App\Traits\JobTraits;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    use JobTraits;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $usersId = User::where('user_type', 2)->pluck('id')->toArray();
        $jobCategoryId = JobCategory::get()->pluck('id')->toArray();
        // $locationId = Locations::pluck('id')->toArray();
        // $workingId = WorkingHour::pluck('id')->toArray();
        // $breakId = BreakTime::pluck('id')->toArray();
        // $type =['fulltime','parttime'];
        $data = [];

        foreach (range(1, 30) as $index) {
            $salaryFrom = $faker->numberBetween(30000, 60000);
            $salaryTo = $faker->numberBetween($salaryFrom, 80000);
            $age_from = $faker->numberBetween(20, 30);
            $ageTo = $faker->numberBetween($age_from, 40);
            $publishedDate = $faker->dateTimeBetween('now', '+15 days');

            $randDay = [];

            for ($i = 1; $i < 2; ++$i) {
                $randDay[] = random_int(1, 7);
            }

            $data[] = [
                'user_id' => $faker->randomElement($usersId),
                'job_title' => $faker->text(100),
                'occupation' => $faker->randomElement($jobCategoryId),
                 'job_location' => random_int(1, 47),
                 'salary_from' => $salaryFrom,
                 'salary_to' => $salaryTo,
                 'working_hours' => random_int(1, 3),
                 'break_time' => random_int(1, 2),
                 'holidays' => json_encode($randDay),
                 'vacation' => $faker->text(100),
                 'age_from' => $age_from,
                 'age_to' => $ageTo,
                 'required_skills' => $faker->text(300),
                 'published' => $publishedDate,
                 'gender' => rand(1, 3),
                 'experience' => rand(1, 4),
                //  'occupation' => rand(1, 9),
                 'japanese_level' => rand(1, 5),
            ];
        }

        DB::table('jobs')->insert($data);
    }
}
