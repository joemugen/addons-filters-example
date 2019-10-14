<?php

namespace App\Models;

use App\Models\Filters\PrevisionBusinessDay\ThreadFilters;
use App\Models\Traits\Filterable;
use App\Models\Traits\Orderable;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thread extends Model
{
    use Filterable, Orderable;

    public $filterableClass = ThreadFilters::class;

    protected $fillable = [
        'owner_id',
        'subject',
        'last_reply_author',
        'last_reply_at',
        // etc...
    ];

    protected $appends = [
        'posts_total'
    ];

    protected $casts = [
        'owner_id' => 'integer',
        'last_reply_author' => 'integer',
        'tags' => 'collection',
        'posts_total' => 'integer'
    ];

    protected $dates = [
        'last_reply_at'
    ];

    public function getPostsTotalAttribute(): int
    {
        return $this->posts()->count();
    }

    public function scopeHasReplies(Builder $builder): Builder
    {
        return $builder->whereHas('posts');
    }

    /**
     * Applies a scope that takes all threads having all specified tags
     *
     * @param Builder $builder
     * @param array $tags
     * @return Builder
     */
    public function scopeHavingTags(Builder $builder, array $tags): Builder
    {
        return $builder->whereHas('tags', static function ($query) use ($tags) {
            $query->where(static function ($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhere('tags.slug', $tag);
                }
            })->select(DB::raw('count(distinct tags.id)'));
        }, '>=', count($tags))->get();
    }


    public function scopeDoesntHaveReplies(Builder $builder): Builder
    {
        return $builder->whereDoesntHave('posts');
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
