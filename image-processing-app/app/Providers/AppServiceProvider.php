<?php

namespace App\Providers;

use App\Services\GoogleImagesApi;
use App\Services\ImageService;
use App\Services\Interfaces\ImageServiceInterface;
use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(SearchInterface::class, GoogleImagesApi::class);
        $this->app->bind(ImageServiceInterface::class, ImageService::class);

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
