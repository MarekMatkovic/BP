<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['title','max_points','page_slug'];

    public function questions() {
        return $this->hasMany(TestQuestion::class);
    }
}
