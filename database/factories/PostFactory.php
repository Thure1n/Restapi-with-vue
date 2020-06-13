<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' =>random_int(1,10),
        'title' =>$faker->text(15),
        'description' =>$faker->text(250),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
