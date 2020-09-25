<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\DouComment;

$factory->define(DouComment::class, function (Faker $faker) {
    return [
        'rate'=>floatval($faker->randomFloat(1,5,9)),
        'content'=> $faker->text(),
        'created_at'=> get_current_time(),
        'updated_at'=> get_current_time()
    ];
});
