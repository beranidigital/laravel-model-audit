<?php

namespace BeraniDigitalID\LaravelModelAudit;

use BeraniDigitalID\LaravelModelAudit\Commands\LaravelModelAuditCommand;
use Illuminate\Support\ServiceProvider;

class LaravelModelAuditServiceProvider extends ServiceProvider
{
    public static string $name = 'laravel-model-audit';

    public static string $viewNamespace = 'laravel-model-audit';

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'laravel-model-audit-migrations');
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
            LaravelModelAuditCommand::class,
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
