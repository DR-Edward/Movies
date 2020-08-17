<?php

use Illuminate\Database\Seeder;
use App\Turn;

class TurnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Turn::create([
            'time' => '15:25:30',
            'active' => true
        ]);
        Turn::create([
            'time' => '17:32:50',
            'active' => false
        ]);
        Turn::create([
            'time' => '11:15:24',
            'active' => true
        ]);
    }
}
