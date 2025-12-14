<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Intonate\TinkerZero\TinkerZeroServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventAccessingMissingAttributes();
        Model::preventLazyLoading($this->app->environment() !== 'production');
        Model::preventSilentlyDiscardingAttributes();

        # ensure you configure the right channel you use
        config([
            'logging.channels.single.path' => \Phar::running()
                ? dirname(\Phar::running(false)) . '/desired-path/your-app.log'
                : storage_path('logs/your-app.log')
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(TinkerZeroServiceProvider::class);
        }
    }
}
