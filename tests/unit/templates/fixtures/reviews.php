<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'task_id' => mt_rand(1,82),
    'author_id' => mt_rand(1,58),
    'score' => mt_rand(1, 5),
    'text' => $faker->realText(100),
    'user_id' => mt_rand(1,58),
];
