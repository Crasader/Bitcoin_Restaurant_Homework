<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {
    static $order_number = 1;
    return [
        'address' => \Helper::getBTCAddress(),
        'order_number' => $order_number++,
        'status' => 0,
        'amount_uah' => 100.55 + $order_number,
        'amount_btc' => \Helper::getUAHToBTC(100.55 + $order_number),
        'description' => $faker->text(),
    ];
});
