<?php

namespace App\Providers;

use App\Contracts\Services\TransferServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Services\TransferService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(TransferServiceInterface::class, TransferService::class);
    }
}
