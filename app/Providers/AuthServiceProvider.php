<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Number;
use App\Models\NumberPreferences;
use App\Policies\CustomerPolicy;
use App\Policies\NumberPolicy;
use App\Policies\NumberPreferencesPolicy;
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
        Customer::class => CustomerPolicy::class,
        Number::class => NumberPolicy::class,
        NumberPreferences::class => NumberPreferencesPolicy::class,
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
