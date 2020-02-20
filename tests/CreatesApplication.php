<?php

namespace Thinktomorrow\ChiefSitestructure\Tests;

use Hash;
use Spatie\Permission\PermissionServiceProvider;
use Thinktomorrow\Squanto\SquantoServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Astrotomic\Translatable\TranslatableServiceProvider;
use Thinktomorrow\Squanto\SquantoManagerServiceProvider;
use Thinktomorrow\Chief\App\Providers\ChiefServiceProvider;
use Thinktomorrow\ChiefSitestructure\Providers\ChiefSitestructureServiceProvider;

trait CreatesApplication
{
    protected function getPackageProviders($app)
    {
        return [
            ChiefSitestructureServiceProvider::class,
            ChiefServiceProvider::class,
            PermissionServiceProvider::class,
            SquantoServiceProvider::class,
            SquantoManagerServiceProvider::class,
            ActivitylogServiceProvider::class,
            TranslatableServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Connection is defined in the phpunit config xml
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', __DIR__.'/../database/testing.sqlite'),
            'prefix'   => '',
        ]);
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = parent::createApplication();

        Hash::setRounds(4);

        return $app;
    }
}
