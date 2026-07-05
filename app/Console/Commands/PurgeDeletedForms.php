<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeDeletedForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-deleted-forms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Form::where(
            'is_deleted',
            true
        )
        ->where(
            'purge_at',
            '<=',
            now()
        )
        ->delete();
    }
}
