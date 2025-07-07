<?php

namespace App\Providers;

use App\Helpers\TokenHelper;
use App\Services\Auth\AuthService;
use App\Services\Auth\IAuthService;
use App\Services\Token\ITokenService;
use App\Services\Token\TokenService;
use App\Services\User\IUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(ITokenService::class, TokenService::class);
        $this->app->bind(IUserService::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
