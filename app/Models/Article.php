<?php

namespace App\Models;

use App\Scopes\DraftScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    protected $fillable = [
        'category_id',
        'user_id',
        'last_user_id',
        'slug',
        'title',
        'subtitle',
        'content',
        'page_image',
        'meta_description',
        'is_original',
        'is_draft',
        'published_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DraftScope);
    }
}
