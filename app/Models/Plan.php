<?php


namespace App\Models;

use App\Models\Tests\Test;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'program_name'
    ];

    /**
     * @var string
     */
    protected static $logName = 'plan';

    /*
     * Explicit date value
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class)->withPivot('takes', 'needs_grading')->withTimestamps();
    }

    public function videos()
    {
        return $this->belongsToMany(UserResource::class)->where('type', 'video');
    }

    public function pdfs()
    {
        return $this->belongsToMany(UserResource::class)->where('type', 'pdf');
    }
}
