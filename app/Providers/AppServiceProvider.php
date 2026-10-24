<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\RepositorioEstudiantes;
use App\Repositories\EloquentRepositorioEstudiantes;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositorioEstudiantes::class, EloquentRepositorioEstudiantes::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
