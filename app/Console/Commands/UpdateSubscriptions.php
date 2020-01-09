<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all user subscription status';

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
        $subscriptions = Subscription::all();
        $now = Carbon::now();
        foreach ($subscriptions as $subscription) {
            $expires_at = new Carbon($subscription->expires_at);
            if ($now >= $expires_at) {
                $subscription->status = 2;
                $subscription->save();

                //email user when subscription ends
            }
        }
        $this->info('Subscription Updated');
    }
}
