<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DailySalesJob;
use App\Models\Order;

class DailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a daily sales report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = now()->toDateString();
        $orders = Order::with(['user', 'items'])
            ->whereDate('created_at', $date)
            ->get();

        DailySalesJob::dispatch($orders, $date);

        $this->info('Daily sales report job dispatched.');
    }
}
