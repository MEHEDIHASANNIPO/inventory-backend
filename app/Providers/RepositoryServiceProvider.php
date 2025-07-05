<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SystemSetting\SystemSettingInterface;
use App\Repositories\SystemSetting\SystemSettingRepository;
use App\Repositories\ProfileSetting\ProfileSettingInterface;
use App\Repositories\ProfileSetting\ProfileSettingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // System Setting Repository
        $this->app->bind(
            SystemSettingInterface::class,
            SystemSettingRepository::class,
        );

        // Profile Setting Repositroy
        $this->app->bind(
            ProfileSettingInterface::class,
            ProfileSettingRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
