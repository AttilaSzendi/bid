<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(rand(1, 3)),
        'price' => 100 * rand(1, 20),
    ];
});
