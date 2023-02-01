<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CommandTest extends TestCase
{
    use RefreshDatabase;

    protected array $arrAccepted = ['status' => 'accepted'];
    protected array $arrShipping = ['status' => 'shipping'];

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function callCommand()
    {
        Artisan::call('order:update:status');
    }

    /** @test */
    public function it_updates_accepted_order_to_shipping()
    {
        $this->assertDatabaseMissing('orders', $this->arrAccepted);
        $this->assertDatabaseMissing('orders', $this->arrShipping);

        Order::factory(1)->create($this->arrAccepted);
        $this->assertDatabaseHas('orders', $this->arrAccepted);
        $this->assertDatabaseMissing('orders', $this->arrShipping);

        $this->callCommand();
        $this->assertDatabaseMissing('orders', $this->arrAccepted);
        $this->assertDatabaseHas('orders', $this->arrShipping);
    }

    /** @test */
    public function it_updates_all_accepted_orders()
    {
        Order::factory(2)->create($this->arrAccepted);
        $this->assertEquals(Order::where($this->arrAccepted)->count(), 2);
        
        $this->callCommand();
        $this->assertEquals(Order::where($this->arrAccepted)->count(), 0);
    }

    /** @test */
    public function it_does_not_touch_new_orders()
    {
        Order::factory(5)->create();
        $count = Order::where($this->arrAccepted)->count();
        
        $this->callCommand();
        $this->assertEquals(
            Order::where($this->arrAccepted)->count(), 
            $count
        );
    }

    /** @test */
    public function it_does_not_touch_shipping_orders()
    {
        Order::factory(1)->create($this->arrShipping);

        $this->callCommand();
        $this->assertEquals(
            Order::where($this->arrShipping)->count(),
            1
        );
    }
}
