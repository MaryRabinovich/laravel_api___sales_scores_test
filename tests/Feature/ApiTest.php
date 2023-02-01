<?php

namespace Tests\Feature;

// use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $url = '/api/insales/scores/update';

    protected array $data = [
        'client_id' => 1,
        'id' => 12345,
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
            [
                'article' => '3005-14',
                'name' => "Усы Фредди Меркьюри",
                'price' => 900,
                'quantity' => 90
            ],
        ],
        'status' => 'new' 
    ]; 

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function the_route_is_accessible_with_correct_json()
    {
        $this->post($this->url, $this->data)->assertStatus(200);
    }

    /** @test */
    public function the_route_is_not_accessible_with_incorrect_json()
    {
        $this->post($this->url)->assertStatus(302);
        
        foreach ([
            ['id' => 'a'],
            ['client_id' => 'a'],
            ['items' => 'a'],
            ['status' => 'a'],
        ] as $item) {
            $this->post($this->url, array_merge($this->data, $item))
                ->assertStatus(302);
        }
    }

    /** @test */
    public function it_returns_correct_response_when_order_has_saled_items()
    {
        $expected = [
            'order_id' => 12345,
            'client_id' => 1,
            'scores' => 9
        ];

        $this->post($this->url, $this->data)->assertJson($expected);
    }

    /** @test */
    public function it_returns_correct_response_when_order_does_not_have_saled_items()
    {
        $this->data['items'][1]['article'] = 'not saled';
        
        $expected = [
            'order_id' => 12345,
            'client_id' => 1,
            'scores' => 0
        ];

        $this->post($this->url, $this->data)->assertJson($expected);
    }
}
