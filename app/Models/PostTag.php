<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Associates
    |--------------------------------------------------------------------------
    */

    /**
     * Get posts of the tag.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);   // table: 'post_post_tag', foreignPivotKey: 'post_tag_id', relatedPivotKey: 'post_id'
    }
}
