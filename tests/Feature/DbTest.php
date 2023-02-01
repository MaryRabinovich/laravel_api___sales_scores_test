<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DbTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function users_table_exists_and_has_some_users()
    {
        $this->assertTrue(User::count() > 0);
    }

    /** @test */
    public function orders_table_exists_and_has_some_orders()
    {
        $this->assertTrue(Order::count() > 0);
    }

    /** @test */
    public function order_items_table_exists_and_has_some_items()
    {
        $this->assertTrue(OrderItem::count() > 0);
    }

    /** @test */
    public function retrieves_order_by_it_s_id()
    {
        $orderFirst = Order::first();
        $orderFound = Order::find($orderFirst->id);
        $this->assertTrue($orderFirst->id === $orderFound->id);
    }

    /** @test */
    public function retrieves_order_items_for_a_given_order()
    {
        $this->assertTrue(Order::first()->items()->count() > 0);
    }
}
