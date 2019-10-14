<?php

use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Thread::class, 15)
            ->create()
            ->each(static function (\App\Models\Thread $thread) {
                $thread->posts()->create(
                    factory(\App\Models\Post::class)->make()->toArray()
                );
            });
    }
}
