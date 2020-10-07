<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Movie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_returns_a_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('movies.index'));

        $response->assertStatus(200);

        $response->assertViewIs('movies.index');
    }

    /**
     * Test for movies api index.
     *
     * @return void
     */
    public function test_index_returns_json_data()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->getJson(route('movies.index'));

        $response->assertStatus(200);
    }

    /**
     * Test for turns store.
     *
     * @return void
     */
    public function test_store_with_image_returns_json_data()
    {
        Storage::fake('testing');
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('movies.store'), [
            'name' => $this->faker->name,
            'publicationDate' => $this->faker->date(),
            'active' => $this->faker->boolean($chanceOfGettingTrue = 50),
            'image' => UploadedFile::fake()->image('test_image.jpg'),
        ]);

        $response->assertStatus(201);
        // no se verifica que la imagen este en el disco porque al ser almacenada se le cambia el nombre y no es posible saberlo
    }

    /**
     * Test for turns delete.
     *
     * @return void
     */
    public function test_delete_returns_json_data()
    {
        $user = factory(User::class)->create();

        $movie = factory(Movie::class)->create();

        $response = $this->actingAs($user)->deleteJson(route('movies.destroy', $movie->id));

        $response->assertStatus(200);
    }
}
