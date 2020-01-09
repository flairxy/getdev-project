<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('admin', function ($user) {
            if ($user->role == 2) {
                return true;
            }
            return false;
        });
        Gate::define('tutor', function ($user) {
            if ($user->role == 1) {
                return true;
            }
            return false;
        });
        Gate::define('student', function ($user) {
            if ($user->role == 0) {
                return true;
            }
            return false;
        });
    }
}
