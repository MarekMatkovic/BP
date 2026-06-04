<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $fillable = ['test_id','question','points'];

    public function test()   { return $this->belongsTo(Test::class); }
    public function options(){ return $this->hasMany(TestOption::class, 'question_id'); }
}
