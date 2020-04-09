<?php

use Faker\Generator as Faker;

use App\Entities\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id'   => 1,
        'title'     => $faker->title,
        'content'   => $faker->text(300),
    ];
});
