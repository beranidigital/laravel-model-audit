<?php

namespace BeraniDigitalID\LaravelModelAudit\Listeners;

use BeraniDigitalID\LaravelModelAudit\Models\AuditTrail;
use Illuminate\Database\Eloquent\Model;

class AuditListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public static function onCreated(Model $model): void
    {
        self::log(__('Created :model', ['model' => $model->getTable()]), null, $model, null, $model->toArray());
    }

    public static function log(string $title, ?string $description = null, $model = null, $old_values = null, $new_values = null, $author_additional_data = null, ?Model $author = null): void
    {
        $author = $user ?? auth()->user();

        $author_additional_data = $author_additional_data ?? [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
        if (! $description) {
            if ($author_additional_data['user_agent'] == 'Symfony') {
                $description = 'Symfony/Laravel/Console/Seeder';
            }
        }
        $model_type = $model ? get_class($model) : null;
        $model_id = $model ? $model->id : null;
        $auditTrail = new AuditTrail;
        $auditTrail->author = $author;
        $auditTrail->title = $title;
        $auditTrail->description = $description;
        $auditTrail->auditable = $model;
        $auditTrail->old_values = $old_values;
        $auditTrail->new_values = $new_values;
        $auditTrail->author_additional_data = $author_additional_data;
        $auditTrail->saveQuietly();

    }

    public static function onUpdated(Model $model): void
    {
        self::log(__('Updated :model', ['model' => $model->getTable()]), null, $model, $model->getOriginal(), $model->toArray());
    }

    public static function onDeleted(Model $model): void
    {
        self::log(__('Deleted :model', ['model' => $model->getTable()]), null, $model, $model->toArray(), null);
    }
}
