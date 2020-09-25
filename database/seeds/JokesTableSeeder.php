<?php

use Illuminate\Database\Seeder;
use App\Models\Joke;

class JokesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Joke::class)->times(100)->create();
    }
}
