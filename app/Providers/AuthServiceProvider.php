<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Client;
use App\Policies\ClientPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Policies\CategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /** The model to policy mappings for the application.
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Client::class => ClientPolicy::class,
        Category::class => CategoryPolicy::class,
    ];
    /** Register any authentication / authorization services.*/
    public function boot(): void
    {
        Gate::define('view-admin-panel', function ($user) {
            return $user->is_admin;
        });
    }
}
