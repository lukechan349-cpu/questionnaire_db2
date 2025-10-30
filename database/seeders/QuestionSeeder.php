<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{

    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('answers')->truncate();
        DB::table('questions')->truncate();

       
        DB::table('questions')->insert([
            [
                'id' => 1,
                'title' => 'Placeholder',
                'body' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Which city do you prefer (Japan, Italy, Paris)',
                'body' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'If you wanted the ability of any animal, what would it be (Eagle, Cheetah, Dolphin)',
                'body' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'What is the darkest color of the list (red, violet, grey)',
                'body' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        DB::table('answers')->insert([
            ['question_id' => 2, 'answer_text' => 'Japan', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 2, 'answer_text' => 'Italy', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 2, 'answer_text' => 'Paris', 'created_at' => now(), 'updated_at' => now()],

            ['question_id' => 3, 'answer_text' => 'Eagle', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'answer_text' => 'Cheetah', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'answer_text' => 'Dolphin', 'created_at' => now(), 'updated_at' => now()],

            ['question_id' => 4, 'answer_text' => 'red', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 4, 'answer_text' => 'violet', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 4, 'answer_text' => 'grey', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
