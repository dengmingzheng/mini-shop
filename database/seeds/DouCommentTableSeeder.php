<?php

use Illuminate\Database\Seeder;
use App\Models\DouMovie;
use App\Models\User;
use App\Models\DouComment;

class DouCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $user_ids = User::all()->pluck('id')->toArray();
        $douMovie_ids = DouMovie::all()->pluck('id')->toArray();

        foreach ($douMovie_ids as $vauel){
            $comments = factory(DouComment::class)
                ->times(20)
                ->make()
                ->each(function ($comment, $index)
                use ($user_ids,$vauel,$faker)
                {
                    // 从用户 ID 数组中随机取出一个并赋值
                    $comment->user_id = $faker->randomElement($user_ids);
                    $comment->movie_id = $vauel;
                });

            DouComment::insert($comments->toArray());
        }

    }
}
