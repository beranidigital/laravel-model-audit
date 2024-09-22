<?php

namespace BeraniDigitalID\LaravelModelAudit\Tests;

use BeraniDigitalID\LaravelModelAudit\LaravelModelAuditServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BeraniDigitalID\\LaravelModelAudit\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelModelAuditServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration_folder = __DIR__ . '/../database/migrations/';
        $files = scandir($migration_folder);
        // sort the files
        sort($files);
        // reverse the array so the latest migration is the first one


        foreach ($files as $file) {

            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $migration = include $migration_folder . $file;
            $migration->up();
        }

    }
}
