<?php

namespace App\Providers;

use App\Interfaces\SpotifyServiceInterface;
use App\Interfaces\YoutubeServiceInterface;
use App\Services\SpotifyService;
use App\Services\YoutubeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(YoutubeServiceInterface::class, YoutubeService::class);
        $this->app->bind(SpotifyServiceInterface::class, SpotifyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
