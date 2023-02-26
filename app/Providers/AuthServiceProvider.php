<?php

namespace App\Providers;

use App\Models\UserSession;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        //
    }

    protected function registerUserGuard()
    {
        Auth::extend('user', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);
            $request = app('request');

            return new RequestGuard(function () use ($provider, $request) {
                $id = UserSession::getActiveUserId();
                if ($id) {
                    return $provider->retrieveById($id);
                }
            }, $request, $provider, $config);
        });
    }
}
