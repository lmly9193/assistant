<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([\App\Observers\PostObserver::class])]
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        //
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'priority',
        'is_published',
        'published_at',
        'expired_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Model Associates
    |--------------------------------------------------------------------------
    */

    /**
     * Get the author of the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    /**
     * Get the category of the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(related: PostCategory::class);  // foreignKey: category_id
    }

    /**
     * Get tags of the post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(related: PostTag::class);   // table: 'post_post_tag', foreignPivotKey: 'post_id', relatedPivotKey: 'post_tag_id'
    }

    /*
    |--------------------------------------------------------------------------
    | Local Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to draft posts.
     */
    public function scopeDraft(Builder $query): void
    {
        $query->where('is_published', false);
    }

    /**
     * Scope a query to published posts.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
