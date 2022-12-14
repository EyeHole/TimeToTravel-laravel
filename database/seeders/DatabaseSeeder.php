<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\City;
use \App\Models\Route;
use \App\Models\Sight;
use \App\Models\Application;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        City::factory(20)->create();
        Route::factory(10)->create();

        for ($i = 0; $i < 30; $i++) {
            Sight::factory(1)->create();
        }

        Application::factory(5)->create()->each(function ($application) {
            if ($application->status == 2) {
                $user = User::find($application->user_id);
                $user->is_author = true;
                $user->save();
            }
        });
    }
}
