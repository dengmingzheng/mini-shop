<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Joke;
use Faker\Generator as Faker;

$factory->define(Joke::class, function (Faker $faker) {

    return [
        'title' => $faker->name(),
        'content' => $faker->sentence(),
        'created_at' => get_current_time(),
        'updated_at'=>get_current_time()
    ];
});
