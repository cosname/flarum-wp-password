<?php

use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Foundation\Application;

return [
    function (Dispatcher $events, Application $app) {
        $app->register(Cosname\Providers\WpHasherProvider::class);
    }
];
