<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'authorId' => 1,
        'title' => $faker->text(30),
        'content' => $faker->text(500),
    ];
});
