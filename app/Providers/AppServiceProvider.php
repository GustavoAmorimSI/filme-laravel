<?php

namespace App\Providers;

use App\Models\Exercise;
use App\Policies\ExercisePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Exercise::class => ExercisePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}