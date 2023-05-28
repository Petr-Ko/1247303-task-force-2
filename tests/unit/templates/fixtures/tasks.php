<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'status' => $faker->randomElement(['new', 'cancelled', 'in_progress', 'in_progress', 'done', 'failed']),
    'customer_id' => random_int(1, 10),
    'title' => $faker->realText(30),
    'description' => $faker->realText(200),
    'latitude' => $faker->latitude(),
    'longitude' => $faker->longitude(),
    'end_date' => $faker->date(),
    'price' => random_int(1000, 10000),
    'category_id' => random_int(1, 8),
    'executor_id' => random_int(0, 50),
];
