<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Module\ModuleInterface;
use App\Repositories\Module\ModuleRepository;
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

        // Module Repositroy
        $this->app->bind(
            ModuleInterface::class,
            ModuleRepository::class,
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
