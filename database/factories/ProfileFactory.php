<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Profile;
use Faker\Generator as Faker;


$factory->define(Profile::class, function (Faker $faker) {

    $gender = array('F', 'M');
    return [
        'name' => $faker->name,
        'slug' => $faker->slug(rand(1, 2)),
        'birthday' => $faker->date($format = 'Y-m-d', $max = '2003-12-31'),
        'nickname' => $faker->userName,
        'gender' => $gender[rand(0, 1)],
    ];
});
