<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'owner_id' => $faker->randomElement([
            \App\User::query()->inRandomOrder()->limit(1)->firstOrFail()->id,
            factory(\App\User::class)->create()->id
        ]),
        'subject' => $faker->sentence(6, true),
        'last_reply_author' => $faker->randomElement([
           \App\User::query()->inRandomOrder()->limit(1)->firstOrFail()->id,
            factory(\App\User::class)->create()->id
        ]),
        'last_reply_at' => $faker->randomElement([
            null,
            $faker->dateTimeThisYear
        ])
    ];
});
