<?php
declare(strict_types=1);
namespace Cornatul\Social;


use Cornatul\Social\Commands\ShareCommand;
use Database\Seeders\SocialAccountsSeed;
use Illuminate\Support\ServiceProvider;
use Cornatul\Social\Contracts\ShareContract;
use Cornatul\Social\Service\ShareService;
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

        $this->app->bind(ShareContract::class, ShareService::class);
        $this->commands([
            ShareCommand::class,
        ]);

    }
}
