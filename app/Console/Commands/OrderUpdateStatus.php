<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class OrderUpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates each accepted order to shipping';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Order::where(['status' => 'accepted'])
            ->update(['status' => 'shipping']);

        return Command::SUCCESS;
    }
}
