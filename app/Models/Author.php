<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Has many audiences through articles (using query builder for many-to-many through)
    public function audiences()
    {
        return Audience::query()
            ->join('article_audience', 'audiences.id', '=', 'article_audience.audience_id')
            ->join('articles', 'article_audience.article_id', '=', 'articles.id')
            ->where('articles.author_id', $this->id)
            ->select('audiences.*')
            ->distinct();
    }
}

