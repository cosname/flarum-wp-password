<?php

namespace Cosname\Providers;

use Illuminate\Support\ServiceProvider;
use Flarum\User\User;
use Hautelook\Phpass\PasswordHash;
use Cosname\Hashing\WpHasher;

class WpHasherProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        WpHasher::setHashers(new PasswordHash(8, true), $this->app->make('hash'));
        User::setHasher(new WpHasher);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Does nothing
    }
}
