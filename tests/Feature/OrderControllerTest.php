<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_order_successfully(): void
    {
        //test with TWD currency
        $orderData1 = [
            'id' => 'A0001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 500,
            'currency' => 'TWD'
        ];

        $response = $this->postJson('/api/orders', $orderData1);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Order created successfully',
            'data' => $orderData1
        ]);


        //test with USD currency
        $orderData2 = [
            'id' => 'A0002',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 500,
            'currency' => 'USD'
        ];

        $response = $this->postJson('/api/orders', $orderData2);
        $response->assertJsonPath('data.price', 15500);
    }

    public function test_create_order_with_non_english_char(): void
    {
        $orderData = [
            'id' => 'A0001',
            'name' => 'Melody Holiday Inn 中文',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 500,
            'currency' => 'TWD'
        ];

        $response = $this->post('/api/orders', $orderData);

        $response->assertStatus(400);
        $response->assertJson([
            'name' => ['The name contains non-English characters.']
        ]);
    }

    public function test_create_order_without_capital_name(): void
    {
        $orderData = [
            'id' => 'A0001',
            'name' => 'melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 500,
            'currency' => 'TWD'
        ];

        $response = $this->post('/api/orders', $orderData);

        $response->assertStatus(400);
        $response->assertJson([
            'name' => ['The name is not capitalized.']
        ]);
    }

    public function test_create_order_with_price_over_limit(): void
    {
        $orderData = [
            'id' => 'A0001',
            'name' => 'melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2001,
            'currency' => 'TWD'
        ];

        $response = $this->post('/api/orders', $orderData);

        $response->assertStatus(400);
        $response->assertJson([
            'price' => ['price is over 2000']
        ]);
    }

    public function test_create_order_with_wrong_currency(): void
    {
        $orderData = [
            'id' => 'A0001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 500,
            'currency' => 'JPY'
        ];

        $response = $this->post('/api/orders', $orderData);
        $response->assertStatus(400);
        $response->assertJson([
            'currency' => ['Currency format is wrong']
        ]);
    }
}
