<?php

namespace App\Console\Commands\Sync;

use App\Helpers\Constants\Queue;
use App\Jobs\Sync\User as SyncUserJob;
use Illuminate\Console\Command;

class SyncUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:user';

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
        \DB::table('users')
            ->selectRaw("*, 'updated' as action")
            ->where('role_id', '!=', 1)
            ->orderBy('id')
            ->chunk(1000, function ($data) {
                SyncUserJob::dispatch($data->toArray(), 'sync')->onQueue(Queue::SYNC_USER_LMS);
                SyncUserJob::dispatch($data->toArray(), 'sync')->onQueue(Queue::SYNC_USER_TS);
            });
    }
}
