<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @package App\Models
 *
 * @property \App\Models\BlogCategory   $category
 * @property \App\Models\User           $user
 * @property string                     $title
 * @property string                     $slug
 * @property string                     $content_html
 * @property string                     $content_raw
 * @property string                     $excerpt
 * @property string                     $published_at
 * @property string                     $is_published
 */

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable
    = [
            'title',
            'slug',
            'category_id',
            'excerpt',
            'content_raw',
            'is_published_at',
            'published_at',
            'user_id',
        ];

    /**
     * Категории статьи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function category()
    {
        //Статья пренадлежит категории
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Автор статьи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //Статья принадлежит пользователю
        return $this->belongsTo(User::class);
    }
}
