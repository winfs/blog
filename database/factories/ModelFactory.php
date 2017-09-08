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
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'status'         => true,
        'confirm_code'   => str_random(64),
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function () use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => 1, 'password' => bcrypt('admin')]);
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'parent_id' => 0,
        'name' => $faker->name,
        'path' => $faker->url,
    ];
});

$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $category_ids = \App\Models\Category::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3,10));
    return [
        'category_id' => $category_ids,
        'user_id' => $user_ids,
        'last_user_id' => $user_ids,
        'slug' => str_slug($title),
        'title' => $title,
        'subtitle' => strtolower($title),
        'content' => $faker->paragraph,
        'page_image' => $faker->imageUrl(),
        'meta_description' => $faker->sentence,
        'is_draft' => false,
        'published_at' => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now'),
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag' => $faker->word,
        'title' => $faker->sentence,
        'meta_description' => $faker->sentence,
    ];
});

$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $article_ids = \App\Models\Article::pluck('id')->random();
    return [
        'user_id' => $user_ids,
        'commentable_id' => $article_ids,
        'commentable_type' => 'App\Models\Article',
        'content' => $faker->paragraph
    ];
});

$factory->define(App\Models\Link::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'link'  => $faker->url,
        'image' => $faker->imageUrl()
    ];
});
