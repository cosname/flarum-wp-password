<?php

use Flarum\Extend;
use Cosname\Provider;

return [
    (new Extend\ServiceProvider)
        ->register(Provider\WpHasherProvider::class)
];
