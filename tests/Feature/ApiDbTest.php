<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiDbTest extends TestCase
{
    use DatabaseMigrations;

    protected string $url = '/api/insales/scores/update';

    protected array $data;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->data = [
            'id' => 101,
            'client_id' => 1,
            'status' => 'new',
            'items' => [
                [
                    'article' => '3005-12',
                    'name' => "Сосиська в тесте",
                    'price' => 100,
                    'quantity' => 12
                ],
                [
                    'article' => '3005-13',
                    'name' => "Дырка от бублика",
                    'price' => 340,
                    'quantity' => 3
                ],
            ]
        ];
    }

    protected function callApi()
    {
        $this->post($this->url, $this->data)->assertStatus(200);
    }

    /** @test */
    public function route_saves_new_order_to_db()
    {
        $count = Order::count();

        $this->callApi();
        $this->assertDatabaseCount('orders', $count + 1);
    }

    /** @test */
    public function route_saves_new_order_with_saled_items_with_correct_scores_field()
    {
        $this->assertDatabaseMissing('orders', ['scores' => 9]);

        $this->callApi();
        $this->assertDatabaseHas('orders', ['scores' => 9]);
    }

    /** @test */
    public function route_saves_new_order_without_saled_items_with_zero_scores_field()
    {
        $this->assertDatabaseMissing('orders', ['scores' => 9]);

        array_pop($this->data['items']);
        $this->callApi();
        $this->assertDatabaseMissing('orders', ['scores' => 9]);
    }

    /** @test */
    public function route_updates_scores_for_existing_orders()
    {
        $this->callApi();
        $this->assertDatabaseHas('orders', ['scores' => 9]);
        
        $saledItem = array_pop($this->data['items']);
        $this->callApi();
        $this->assertDatabaseMissing('orders', ['scores' => 9]);
        
        array_push($this->data['items'], $saledItem);
        $this->callApi();
        $this->assertDatabaseHas('orders', ['scores' => 9]);
    }

    /** @test */
    public function route_saves_order_items_for_new_order()
    {
        $count = OrderItem::count();

        $this->callApi();
        $this->assertTrue(OrderItem::count() === $count + 2);
    }

    /** @test */
    public function route_updates_order_items_for_existing_order()
    {
        $this->callApi();
        $this->assertDatabaseHas('order_items', ['name' => 'Сосиська в тесте']);

        $this->data['items'][0]['name'] = 'Сосиська в соуси';
        $this->callApi();
        $this->assertDatabaseHas('order_items', ['name' => 'Сосиська в соуси']);
        $this->assertDatabaseMissing('order_items', ['name' => 'Сосиська в тесте']);
    }
}
