<?php

namespace App\Models;

use App\User;
use App\Tools\Markdowner;
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

        static::addGlobalScope(new DraftScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 获得此文章下的所有标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * 获得此文章下的所有评论
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (!config('services.youdao.appKey') || !config('services.youdao.appSecret')) {
            $this->setUniqueSlug($value, str_random(5));
        } else {
            $this->setUniqueSlug(translug($value), '');
        }
    }

    public function setUniqueSlug($value, $extra)
    {
        $slug = str_slug($value . '-' . $extra);

        if (static::whereSlug($slug)->exists()) {
            $this->setUniqueSlug($slug, (int) $extra + 1);
            return;
        }

        $this->attributes['slug'] = $slug;
    }

    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($data);
    }
}
