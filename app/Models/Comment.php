<?php

namespace App\Models;

use App\User;
use App\Tools\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取所有拥有的 commentable 模型
     */
    public function commentable()
    {
        return $this->morphTo();
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
