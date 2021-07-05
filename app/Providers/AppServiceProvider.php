<?php

namespace App\Providers;

use App\Models\Users\Admin;
use App\Models\Users\Institution;
use App\Models\Users\Student;
use App\Models\Users\SuperUser;
use App\Models\Users\TestCreator;
use App\Models\Users\TestGrader;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'Super User' => SuperUser::class,
            'Test Creator' => TestCreator::class,
            'Student' => Student::class,
            'Test Grader' => TestGrader::class,
            'Institution' => Institution::class,
            'Admin' => Admin::class
        ]);
    }
}
