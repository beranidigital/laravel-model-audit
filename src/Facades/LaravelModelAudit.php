<?php

namespace BeraniDigitalID\LaravelModelAudit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BeraniDigitalID\LaravelModelAudit\LaravelModelAudit
 */
class LaravelModelAudit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BeraniDigitalID\LaravelModelAudit\LaravelModelAudit::class;
    }
}
