<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Visual' => 'App\Policies\VisualPolicy',
        'App\Quiz' => 'App\Policies\QuizPolicy',
        'App\Question' => 'App\Policies\QuestionPolicy',
        'App\Course' => 'App\Policies\CoursePolicy',
        'App\Lesson' => 'App\Policies\LessonPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
      $this->registerPolicies();
        //
    }
}
