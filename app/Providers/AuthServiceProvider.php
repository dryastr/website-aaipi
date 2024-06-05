<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Helpers\AaipiHasher;
use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->app->make('hash')->extend('aaipi', function () {
            return new AaipiHasher();
        });

        if (Schema::hasTable('permissions')) {
            $minute = 60 * 60;
            $permissions = Cache::remember('permissions', $minute, function () {
                return Permission::all();
            });

            foreach ($permissions as $permission) {
                Gate::define($permission->action, function ($user) use ($permission) {
                    return $user->hasPermission()->where('permission_id', $permission['id'])->first() ? true : false;
                });
            }
        }
    }
}
