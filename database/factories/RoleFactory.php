<?php

declare(strict_types = 1);

use App\Role;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Role::class, function(Faker $faker) {
    return [
        'name' => $faker->name,
        'full_access' => false,
        'accessible_routes' => [],
        'description' => $faker->words(3, true),
    ];
});
