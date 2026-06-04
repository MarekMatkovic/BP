<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','content','page_slug','image_url','image_position'];
    public function section()
    {
        return $this->belongsTo(PageSection::class, 'page_slug', 'slug');
    }
}
