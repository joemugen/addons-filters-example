<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'thread_id',
        'author_id',
        'content',
        'likes',
        'dislikes',
    ];

    protected $casts = [
        'thread_id' => 'integer',
        'author_id' => 'integer',
        'likes' => 'integer',
        'dislikes' => 'integers'
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function thread(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }
}
