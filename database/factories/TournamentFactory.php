<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Tournament::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'name' => $faker->word(),
        'cena' => '123',
        'pocet_teamu' => '5',
        'pocet_hracu' => '8',
        'typ_hracu' => 'hezci mladi chlapci',
        'poplatek' => '100',
        'vlastnost_teamu' => 'rok stary'
    ];
});

