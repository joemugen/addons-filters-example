<?php

/** @var Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, static function (Faker $faker) {
    return [
        'thread_id' => $faker->randomElement([
            \App\Models\Thread::all()->random(1)->first()->id,
            factory(\App\Models\Thread::class)->create()->id
        ]),
        'author_id' => $faker->randomElement([
            \App\Models\Thread::all()->random(1)->first()->id,
            factory(\App\User::class)->create()->id
        ]),
        'content' => $faker->paragraph(5, true),
        'likes' => random_int(0, 1337),
        'dislikes' => random_int(0, 42),
    ];
});
