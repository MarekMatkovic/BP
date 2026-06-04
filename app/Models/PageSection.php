<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['slug','title'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'page_slug', 'slug');
    }
}
