<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);


        factory(App\User::class, 2)->create();
        factory(App\Team::class, 2)->create();
        factory(App\Tournament::class, 2)->create();
        factory(App\Match::class, 2)->create();
        factory(App\Statistic::class, 2)->create();
        factory(App\Sponsor::class, 2)->create();



    }
}
