<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
        public function it_fetches_all_products()
            {
            // Create a user and a token for them
            $user = User::factory()->create();
            $token = $user->createToken('TestToken')->plainTextToken;

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('/api/products');

            $response->assertStatus(200)->assertJsonStructure([
                    '*' => ['id', 'name', 'description', 'price']
            ]);
        }

}
