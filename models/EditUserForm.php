<?php

namespace app\models;

use yii\base\Model;

class EditUserForm extends Model
{
    public $avatar;
    public $firstName;
    public $lastName;
    public $email;
    public $birthday;
    public $phoneNumber;
    public $telegram;
    public $information;
    public $categories;

    public function rules()
    {
        return [
            [['birthday', ], 'safe'],
            [['phoneNumber', ], 'string', 'min' => 11, 'max' => 11],
            [['telegram'],'string', 'max' => 50],
            [['birthday', ], 'date','format' => 'php:Y-m-d'],
            [['email', ], 'email'],
            [['avatar', ], 'image'],
            [['firstName', 'lastName','information'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatar' => 'Сменить аватар',
            'firstName' => 'Ваше имя',
            'lastName' => 'Ваша фамилия',
            'email' => 'Email',
            'birthday' => 'Дата рождения',
            'phoneNumber' => 'Номер телефона',
            'telegram' => 'Telegram',
            'information' => 'Информация о себе',
            'categories' => 'Выбор специализаций',
        ];
    }

    public function saveChanges(User $user)
    {
            //return $this->getIterator();
    }


}