<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();

        Order::factory(1)->create(['client_id' => 1]);
        OrderItem::factory(1)->create(['order_id' => Order::first()->id]);

        Sales::create([
            'article' => '3005-13',
            'points' => 3
        ]);
    }
}
