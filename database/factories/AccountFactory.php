<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => bcrypt('123456'),
        'login_num'=>0,
        'created_at' => get_current_time(),
        'updated_at'=>get_current_time()
    ];
});
