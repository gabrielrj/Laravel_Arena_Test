<?php

namespace App\Providers;

use App\Factories\CustomerFactory;
use App\Factories\NumberFactory;
use App\Factories\NumberPreferencesFactory;
use App\Interfaces\Factories\CustomerFactoryInterface;
use App\Interfaces\Factories\NumberFactoryInterface;
use App\Interfaces\Factories\NumberPreferencesFactoryInterface;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
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
        $this->app->bind(CustomerFactoryInterface::class, CustomerFactory::class);
        $this->app->bind(NumberFactoryInterface::class, NumberFactory::class);
        $this->app->bind(NumberPreferencesFactoryInterface::class, NumberPreferencesFactory::class);
    }
}
