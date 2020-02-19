<?php

namespace Thinktomorrow\ChiefSitestructure\Tests;

use Thinktomorrow\Chief\Users\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Factory;
use Thinktomorrow\Chief\Authorization\Role;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Thinktomorrow\Chief\Authorization\AuthorizationDefaults;
use Thinktomorrow\ChiefSitestructure\Tests\CreatesApplication;
use Thinktomorrow\ChiefSitestructure\Tests\ChiefDatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, ChiefDatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Load the chief factories
        $this->app->make(Factory::class)->load(__DIR__.'/../vendor/thinktomorrow/chief/database/factories');

        $this->setUpDatabase();
    }

    protected function asAdmin()
    {
        // Allow multiple calls in one test run.
        if (($admin = User::first()) && $this->isAuthenticated('chief')) {
            return $this->actingAs($admin, 'chief');
        }

        $admin = factory(User::class)->create();
        $admin->assignRole(Role::firstOrCreate(['name' => 'admin']));

        return $this->actingAs($admin, 'chief');
    }

    protected function setUpDefaultAuthorization()
    {
        AuthorizationDefaults::permissions()->each(function ($permissionName) {
            Artisan::call('chief:permission', ['name' => $permissionName]);
        });

        AuthorizationDefaults::roles()->each(function ($defaultPermissions, $roleName) {
            Artisan::call('chief:role', ['name' => $roleName, '--permissions' => implode(',', $defaultPermissions)]);
        });
    }
}
