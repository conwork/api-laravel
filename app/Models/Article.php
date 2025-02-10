<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'article',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%$search%")
            ->orWhere('article', 'like', "%$search%");
    }
}
