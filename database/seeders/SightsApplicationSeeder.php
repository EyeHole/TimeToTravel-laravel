<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SightsApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            SightApplication::factory(1)->create();
        }
    }
}
