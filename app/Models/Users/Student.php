<?php

namespace App\Models\Users;

use App\Models\Comment;
use App\Models\Meeting;
use App\Models\Plan;
use App\Models\StudentFile;
use App\Models\StudentFileResponse;
use App\Models\Tests\Answer;
use App\Models\Tests\Test;
use App\Models\Tests\TestTake;
use App\Models\User;
use App\Models\UserResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {
    use HasFactory, SoftDeletes;

    public $loginPage = "/student";

    protected $dates = ['deleted_at'];

    public function user() {
        return $this->morphOne(User::class, 'user');
    }

    public function tests() {
        return $this->belongsToMany(Test::class)->withPivot('takes', 'needs_grading', 'plan_id')->withTimestamps();
    }

    public function addTest(Test $test, $takes = 1, $needsGrading = true) {
        $this->tests()->attach($test, ['takes' => $takes, 'needs_grading' => $needsGrading]);
    }

    public function getAccessibleTestsAttribute() {
        return $this->tests->filter(function ($test){
            return $this->testTakes->where('test_id', $test->id)->where('plan_id', $test->pivot->plan_id)->where('finished', true)->count() < $test->pivot->takes;
        });
    }

    public function hasAccess(Test $test) {
        return $this->accessibleTests->contains($test);
    }

    public function answers() {
        return $this->hasManyThrough(Answer::class, TestTake::class);
    }

    public function getCurrentTestTake(Test $test) {
        return $this->testTakes()->where('test_id', $test->id)
            ->where('finished', false)
            ->first();
    }

    public function testTakes() {
        return $this->hasMany(TestTake::class);
    }

    public function testTakesWithTrashed() {
        return $this->hasMany(TestTake::class)->with(['test' => function($q) {
            $q->withTrashed();
        }]);
    }

    public function scopeHasUngradedAnswers($query) {
        return $query->whereHas('answers', function ($q) {
            $q->ungraded();
        });
    }

    public function hasDocumentReview() {
        return $this->plans()->where('document_review', true)->exists();
    }

    public function plans() {
        return $this->belongsToMany(Plan::class)->withTimestamps();
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'resource');
    }


    public function files() {
        return $this->hasMany(StudentFile::class);
    }

    public function meetings() {
        return $this->hasMany(Meeting::class);
    }

    public function futureMeetings() {
        return $this->meetings()->where('date_time', '>', Carbon::now())->orderBy('date_time', 'asc');
    }

    public function pastMeetings() {
        return $this->meetings()->where('date_time', '<=', Carbon::now())->orderBy('date_time', 'desc');
    }

    public function studentFileResponses() {
        return $this->morphMany(StudentFileResponse::class, 'owner');
    }

    public function getPdfs() {
        $plans = $this->plans;
        $resources = [];
        $seen = collect([]);
        foreach ($plans as $plan) {
            $planPdfs = $plan->pdfs->filter(function ($pdf) use ($seen) {
                if (!$seen->contains($pdf->title)) {
                    $seen->push($pdf->title);
                    return true;
                }
                return false;
            });


            if (count($planPdfs)) {
                $resources[$plan->name] = $planPdfs;
            }
        }

        $studentPdfs = $this->userResources()->where('type', 'pdf')->get();
        $individualPdfs = $studentPdfs->filter(function ($pdf) use ($seen) {
            if (!$seen->contains($pdf->title)) {
                $seen->push($pdf->title);
                return true;
            }
            return false;
        });

        if (count($individualPdfs)) {
            $resources['Individual Pdfs'] = $individualPdfs;
        }

        return $resources;
    }

    public function getVideos() {
        $plans = $this->plans;
        $resources = [];
        $seen = collect([]);

        foreach ($plans as $plan) {
            $planVideos = $plan->videos->filter(function ($video) use ($seen) {
                if (!$seen->contains($video->title)) {
                    $seen->push($video->title);
                    return true;
                }
                return false;
            });

            if (count($planVideos)) {
                $resources[$plan->name] = $planVideos;
            }
        }
        $studentVideos = $this->userResources()->where('type', 'video')->get();
        $individualVideos = $studentVideos->filter(function ($video) use ($seen) {
            if (!$seen->contains($video->title)) {
                $seen->push($video->title);
                return true;
            }
            return false;
        });
        if (count($individualVideos)) {
            $resources['Individual Videos'] = $individualVideos;
        }
        return $resources;
    }

    public function userResources() {
        return $this->belongsToMany(UserResource::class);
    }
}
