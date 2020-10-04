<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class TurnControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    /**
     * Test for turns index.
     *
     * @return void
     */
    public function test_Index_Returns_Index_Data()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('turns.index'));

        $response->assertStatus(200);

        $response->assertViewIs('turns.index');
    }

    /**
     * Test for turns api index.
     *
     * @return void
     */
    public function test_Index_Returns_Index_api_Data()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->getJson(route('turns.index'));

        $response->assertStatus(200);
    }
}
