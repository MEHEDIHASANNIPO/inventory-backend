<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Role\RoleInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Module\ModuleInterface;
use App\Repositories\Module\ModuleRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Permission\PermissionInterface;
use App\Repositories\Permission\PermissionRepository;
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

        // Permission Repositroy
        $this->app->bind(
            PermissionInterface::class,
            PermissionRepository::class,
        );

        // Role Repositroy
        $this->app->bind(
            RoleInterface::class,
            RoleRepository::class,
        );

        // Category Repositroy
        $this->app->bind(
            CategoryInterface::class,
            CategoryRepository::class,
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
