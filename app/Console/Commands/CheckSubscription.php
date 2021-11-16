<?php

namespace App\Console\Commands;

use App\Models\AppUser;
use App\Models\UserSubscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Cron');
        $subscriptions = UserSubscription::where()->pluck('user_id')->toArray();
        if(count($subscriptions)>0) {
            AppUser::whereIn('id', $subscriptions)->update(['status' => 0]);
        }
    }
}
