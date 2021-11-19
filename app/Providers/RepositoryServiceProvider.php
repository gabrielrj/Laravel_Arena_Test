<?php

namespace App\Providers;

use App\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Interfaces\Repositories\NumberPreferencesRepositoryInterface;
use App\Interfaces\Repositories\NumberRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\NumberPreferencesRepository;
use App\Repositories\NumberRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(NumberRepositoryInterface::class, NumberRepository::class);
        $this->app->bind(NumberPreferencesRepositoryInterface::class, NumberPreferencesRepository::class);
    }
}
