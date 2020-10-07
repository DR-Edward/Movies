<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Turn;

class TurnControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /**
     * Test for turns index.
     *
     * @return void
     */
    public function test_index_returns_a_view()
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
    public function test_index_returns_json_data()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->getJson(route('turns.index'));

        $response->assertStatus(200);
    }

    /**
     * Test for turns store.
     *
     * @return void
     */
    public function test_store_returns_json_data()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('turns.store'), [
            'time' => $this->faker->time(),
            'active' => $this->faker->boolean($chanceOfGettingTrue = 50),
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test for turns put update.
     *
     * @return void
     */
    public function test_put_update_returns_json_data()
    {
        $user = factory(User::class)->create();

        $turn = factory(Turn::class)->create();

        $response = $this->actingAs($user)->putJson(route('turns.update', 1), $turn->toArray());

        $response->assertStatus(200);
    }
    
    /**
     * Test for turns delete.
     *
     * @return void
     */
    public function test_delete_returns_json_data()
    {
        $user = factory(User::class)->create();

        $turn = factory(Turn::class)->create();

        $response = $this->actingAs($user)->deleteJson(route('turns.destroy', $turn->id));

        $response->assertStatus(200);
    }
}
