<?php

namespace app\models;


use app\models\User;

class UserRegistrationForm extends User
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_repeat;
    public $city_id;
    public $is_executor;


    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'password_repeat', 'city_id', 'is_executor'], 'safe'],
            [['first_name', 'last_name', 'email', 'password', 'password_repeat', 'city_id'], 'required'],
            [['city_id', 'is_executor'], 'integer'],
            [['password','password_repeat'], 'string', 'min' => 8],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            ['email', 'email'],
            ['email', 'unique'],
            ['password', 'compare']
        ];
    }

}