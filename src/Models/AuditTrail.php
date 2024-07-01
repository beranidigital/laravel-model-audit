<?php

namespace BeraniDigitalID\LaravelModelAudit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'author_additional_data',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'author_additional_data' => 'array',
    ];



    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(App\Models\User::class);
    }

    public function getDiff(): array
    {
        $old = $this->old_values ?? [];
        $new = $this->new_values ?? [];
        $diff = [];
        foreach ($old as $key => $value) {
            if (isset($new[$key])) {
                if ($new[$key] != $value) {
                    $diff[$key] = [
                        'old' => $value,
                        'new' => $new[$key],
                    ];
                }
            } else {
                $diff[$key] = [
                    'old' => $value,
                    'new' => null,
                ];
            }
        }
        foreach ($new as $key => $value) {
            if (! isset($old[$key])) {
                $diff[$key] = [
                    'old' => null,
                    'new' => $value,
                ];
            }
        }
        // convert array to string
        foreach ($diff as $key => $value) {
            if (is_array($value['old'])) {
                $diff[$key]['old'] = json_encode($value['old']);
            }
            if (is_array($value['new'])) {
                $diff[$key]['new'] = json_encode($value['new']);
            }
            $diff[$key]['key'] = $key;
        }

        return $diff;
    }
}
