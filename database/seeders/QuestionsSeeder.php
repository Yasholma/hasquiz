<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'quiz_id' => 1,
            'question' => 'What is the most popular scripting language?',
            'time' => 30,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('questions')->insert([
            'quiz_id' => 1,
            'question' => 'What is Java?',
            'time' => 45,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('questions')->insert([
            'quiz_id' => 1,
            'question' => 'Who is the founder of twitter?',
            'time' => 20,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 1,
            'answer' => 'Java',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 1,
            'answer' => 'Cobol',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 1,
            'answer' => 'Python',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 1,
            'answer' => 'Javascript',
            'correct' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 2,
            'answer' => 'Native',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 2,
            'answer' => 'Progamming',
            'correct' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 2,
            'answer' => 'Singing',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 2,
            'answer' => 'Dancing',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 3,
            'answer' => 'Dangote',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 3,
            'answer' => 'Bill Gate',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 3,
            'answer' => 'Steve Jobs',
            'correct' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('answers')->insert([
            'question_id' => 3,
            'answer' => 'Jack Dorsey',
            'correct' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
