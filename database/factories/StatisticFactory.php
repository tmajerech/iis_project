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

$factory->define(App\Statistic::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'match_id' => '1',
        'vojenske_skore' => '420',
        'ekonomicke_skore' => '421',
        'technologicke_skore' => '422',
        'socialni_skore' => '423',
        'doba_preziti' => '42'
    ];
});

