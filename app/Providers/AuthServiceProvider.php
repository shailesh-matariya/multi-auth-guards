<?php

namespace App\Providers;

use App\Guards\App2Guard;
use App\Guards\App3Guard;
use Illuminate\Container\Container;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        // Custom guards have been registered here
        Auth::extend('api2Provider', function (Container $app) {
            return new App2Guard($app['request']);
        });
        Auth::extend('api3Provider', function (Container $app) {
            return new App3Guard($app['request']);
        });

        $this->registerPolicies();

        //
    }
}
