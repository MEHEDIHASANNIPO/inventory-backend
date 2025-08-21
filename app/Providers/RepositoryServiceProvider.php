<?php

namespace App\Providers;

use App\Models\Salary;
use App\Models\Transfer;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartInterface;
use App\Repositories\Role\RoleInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\user\UserRepository;
use App\Repositories\Brand\BrandInterface;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Order\OrderRepository;
use Spatie\Backup\BackupDestination\Backup;
use App\Repositories\Backup\BackupInterface;
use App\Repositories\Module\ModuleInterface;
use App\Repositories\Salary\SalaryInterface;
use App\Repositories\Backup\BackupRepository;
use App\Repositories\Module\ModuleRepository;
use App\Repositories\Salary\SalaryRepository;
use App\Repositories\Expense\ExpenseInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Expense\ExpenseRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Employee\EmployeeInterface;
use App\Repositories\Supplier\SupplierInterface;
use App\Repositories\Transfer\TransferInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Transfer\TransferRepository;
use App\Repositories\WareHouse\WareHouseInterface;
use App\Repositories\WareHouse\WareHouseRepository;
use App\Repositories\Permission\PermissionInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\SystemSetting\SystemSettingInterface;
use App\Repositories\SystemSetting\SystemSettingRepository;
use App\Repositories\ProfileSetting\ProfileSettingInterface;
use App\Repositories\ProfileSetting\ProfileSettingRepository;
use App\Repositories\ExpenseCategory\ExpenseCategoryInterface;
use App\Repositories\ExpenseCategory\ExpenseCategoryRepository;

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

        // Brand Repositroy
        $this->app->bind(
            BrandInterface::class,
            BrandRepository::class,
        );

        // WareHouse Repositroy
        $this->app->bind(
            WareHouseInterface::class,
            WareHouseRepository::class,
        );

        // Supplier Repositroy
        $this->app->bind(
            SupplierInterface::class,
            SupplierRepository::class,
        );

        // Product Repositroy
        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class,
        );

        // Expense Category Repositroy
        $this->app->bind(
            ExpenseCategoryInterface::class,
            ExpenseCategoryRepository::class,
        );

        // Expense Repositroy
        $this->app->bind(
            ExpenseInterface::class,
            ExpenseRepository::class,
        );

        // Employee Repositroy
        $this->app->bind(
            EmployeeInterface::class,
            EmployeeRepository::class,
        );

        // Salary Repositroy
        $this->app->bind(
            SalaryInterface::class,
            SalaryRepository::class,
        );

        // Customer Repositroy
        $this->app->bind(
            CustomerInterface::class,
            CustomerRepository::class,
        );

        // Cart Repositroy
        $this->app->bind(
            CartInterface::class,
            CartRepository::class,
        );

        // Order Repositroy
        $this->app->bind(
            OrderInterface::class,
            OrderRepository::class,
        );

        // Transfer Repositroy
        $this->app->bind(
            TransferInterface::class,
            TransferRepository::class,
        );

        // Backup Repositroy
        $this->app->bind(
            BackupInterface::class,
            BackupRepository::class,
        );

        // User Repositroy
        $this->app->bind(
            UserInterface::class,
            UserRepository::class,
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
