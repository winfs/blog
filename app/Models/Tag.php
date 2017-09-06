<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tag', 'title', 'subtitle', 'meta_description'
    ];

    /**
     * 获得此标签下的所有文章
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
