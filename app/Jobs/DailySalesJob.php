<?php

namespace App\Jobs;

use App\Mail\DailySalesReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DailySalesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Collection $orders;
    protected string $date;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $orders, string $date)
    {
        $this->orders = $orders;
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->orders->each(function ($order) {
            $order->total = $order->items->sum(
                fn ($item) => $item->price * $item->quantity
            );
        });

        $dailyTotal = $this->orders->sum('total');

        Mail::to(config('shop.admin_email'))
            ->send(new DailySalesReport($this->orders, $dailyTotal, $this->date));
    }
}
