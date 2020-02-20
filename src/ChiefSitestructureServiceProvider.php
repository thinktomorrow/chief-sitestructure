<?php

namespace Thinktomorrow\ChiefSitestructure\Providers;

use Illuminate\Support\ServiceProvider;

class ChiefSitestructureServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
