<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quizzes')->insert([
            'title' => 'Software Development',
            'description' => 'This is a software development quiz.',
            'total_time' => 95,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
