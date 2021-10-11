<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Application::factory(5)->create()->each(function ($application) {
            if ($application->status == 2) {
                $user = User::find($application->user_id);
                $user->is_author = true;
                $user->save();
            }
        });
    }
}
