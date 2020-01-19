<?php

namespace App\Console\Commands;

use App\Models\StudentsCourse;
use App\Models\Transaction;
use Illuminate\Console\Command;

class IncompleteTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:iTransactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear incomplete transactions';

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
        // $courses = StudentsCourse::whereStatus(0)->get();
        $transactions = Transaction::whereTransactionId(null)->get();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
        $this->info('Incomplete transactions cleared');
    }
}
