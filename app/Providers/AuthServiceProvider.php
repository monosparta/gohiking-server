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

        Passport::routes();

        // 設定token的有效期
        Passport::tokensExpireIn(now()->addHours(1)); // 設定使用期限
        Passport::refreshTokensExpireIn(now()->addDays(1)); // 設定可刷新的期限
        Passport::personalAccessTokensExpireIn(now()->addMonths(1)); // 設定可存取期限
    }
}
