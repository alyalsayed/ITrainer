<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-notifications', function (User $user) {
            return $user->userType === 'admin';
        });

        Gate::define('view-dashboard', function (User $user) {
            return $user->userType === 'admin';
        });

        // Add manage-attendance gate definition
        Gate::define('manage-attendance', function (User $user) {
            return $user->userType === 'admin';
        });

        // Add manage-tracks gate definition
        Gate::define('manage-tracks', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
