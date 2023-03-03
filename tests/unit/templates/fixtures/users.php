<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'first_name' => $faker->firstName(),
    'last_name' => $faker->lastName(),
    'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'email' => $faker->email,
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'birthday' => $faker->date(),
    'avatar_file_id' => random_int(1,11),
    'city_id' => random_int(1,1087),
    'is_executor' =>random_int(0,1),
];