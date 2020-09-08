<?php

use Illuminate\Database\Seeder;
use App\Movie;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::create([
            'name' => 'Iron man: el hombre de hierro',
            'publicationDate' => '2008-4-30',
            'imageLink' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcT95Db6V4jzEkaZjnWEV5n0qHu1a2InkUgafj3lWQDRxQIxYvL3',
            'active' => true
        ]);
        Movie::create([
            'name' => 'Thor: Ragnarok',
            'publicationDate' => '2017-10-10',
            'imageLink' => 'https://pics.filmaffinity.com/Thor_Ragnarok-702806827-large.jpg',
            'active' => false
        ]);
    }
}
