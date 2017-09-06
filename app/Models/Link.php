<?php

namespace App\Models;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'link', 'image', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StatusScope());
    }
}
