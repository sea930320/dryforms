<?php

namespace App\Providers;

use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\EquipmentInterface;
use App\Repositories\Contracts\ModelInterface;
use App\Repositories\Contracts\StatusInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\EquipmentRepository;
use App\Repositories\Eloquent\ModelRepository;
use App\Repositories\Eloquent\StatusRepository;
use App\Repositories\Eloquent\TeamRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryInterface::class, CategoryRepository::class);
        $this->app->singleton(ModelInterface::class, ModelRepository::class);
        $this->app->singleton(StatusInterface::class, StatusRepository::class);
        $this->app->singleton(TeamInterface::class, TeamRepository::class);
        $this->app->singleton(EquipmentInterface::class, EquipmentRepository::class);
    }
}
