<?php

namespace BeraniDigitalID\LaravelModelAudit;

use BeraniDigitalID\LaravelModelAudit\Listeners\AuditListener;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelModelAuditServiceProvider extends PackageServiceProvider
{
    public static string $name = 'laravel-model-audit';

    public static string $viewNamespace = 'laravel-model-audit';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('beranidigital/laravel-model-audit');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        $package->hasMigrations($this->getMigrations());

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {


        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/laravel-model-audit/{$file->getFilename()}"),
                ], 'laravel-model-audit-stubs');
            }
        }


    }

    public function boot()
    {
        Event::listen('eloquent.created: *', function ($name, $models) {
            foreach ($models as $model) {
                AuditListener::onCreated($model);
            }
        });
        Event::listen('eloquent.updated: *', function ($name, $models) {
            foreach ($models as $model) {
                AuditListener::onUpdated($model);
            }
        });
        Event::listen('eloquent.deleted: *', function ($name, $models) {
            foreach ($models as $model) {
                AuditListener::onDeleted($model);
            }
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'beranidigital/laravel-model-audit';
    }


    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_laravel_model_audit_table',
        ];
    }
}
