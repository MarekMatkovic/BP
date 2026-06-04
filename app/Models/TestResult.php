<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['user_id','test_id','points','completed_at'];
    protected $dates = ['completed_at'];

    public function test()  { return $this->belongsTo(Test::class); }
    public function user()  { return $this->belongsTo(User::class); }

    public function getPercentAttribute(): float {
        return $this->test && $this->test->max_points > 0
            ? round(($this->points / $this->test->max_points) * 100, 2)
            : 0.0;
    }
}
