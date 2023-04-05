<?php

namespace app\models;

use Yii;

class UserRegistration extends Users
{

    public $password;
    public $password_repeat;
    public $city_id;

    public function attributeLabels()
    {
        return
            [
                'first_name' => "Имя",
                'last_name' => 'Фамилия',
                'email' => 'Email',
                'password' => 'Пароль',
                'password_repeat' => 'Повтор пароля',
                'city_id' => 'Город',
                'is_executor' => 'я собираюсь откликаться на заказы',
            ];
    }

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

    public function AddUser($params)
    {

        $this->load($params);
        if(!$this->validate()) {

            $this->getErrors();
        }
        else {

           $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
           $this->save();
        }

    }
}