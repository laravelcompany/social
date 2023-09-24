<?php
declare(strict_types=1);
namespace Cornatul\Social;


use Database\Seeders\SocialAccountsSeed;
use Illuminate\Support\ServiceProvider;

class SocialServiceProvider extends ServiceProvider
{

    public final function boot(): void
    {

        $this->loadRoutesFrom(__DIR__ . '/../routes/social.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'social');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->mergeConfigFrom(
            __DIR__ . '/Config/social.php', 'social'
        );

    }

    public final function register(): void
    {
        $this->app->singleton(SocialAccountsSeed::class, function ($app) {
            return new SocialAccountsSeed();
        });
    }
}
