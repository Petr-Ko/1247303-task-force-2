<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'task_id' => mt_rand(1,82),
    'executor_id' => mt_rand(1,58),
    'price' => mt_rand(1000, 10000),
    'description' => $faker->realText(100),
    'rejected' => 0,
];
