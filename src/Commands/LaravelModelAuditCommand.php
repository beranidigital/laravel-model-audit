<?php

namespace BeraniDigitalID\LaravelModelAudit\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'laravel-model-audit:command',
    description: 'My command'
)]
class LaravelModelAuditCommand extends \Illuminate\Console\Command
{
    public $signature = 'laravel-model-audit:command';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
