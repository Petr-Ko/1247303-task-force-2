<?php

namespace app\models;

use PhpParser\Node\Expr\New_;
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
            [['birthday', 'categories' ], 'safe'],
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

    public function userCategories($userId)
    {

        $user = User::findOne($userId);

        return $user->getExecutorCategories()->indexBy('category_id')->select('category_id')->column();

    }

    public function newAvatar(string $filePath, User $user)
    {
        $file = new Files();

        $file->path = $filePath;

        if ($file->save()) {

            $user->avatar_file_id = $file->file_id;

            if ($user->save()) {

                return true;
            }
        }
    }
    public function uploadAvatar()
    {

        $randName = mt_rand(10000, 1000000);

        $filePath = 'uploads/' . $randName . '.' . $this->avatar->extension;

        if ($this->avatar->saveAs($filePath)) {

            return $filePath;
        }

    }


    public function saveChanges(User $user)
    {

        $resultSaveCategory = false;
        $resultSaveUser = false;


        foreach ($user->executorCategories as $lastCategory) {

            $lastCategory->delete();
        }

        if ($this->categories) {

            foreach ($this->categories as $newCategory) {

                $category = new ExecutorCategories();
                $category->executor_id = $user->user_id;
                $category->category_id = $newCategory;
                $resultSaveCategory = $category->save();
            }
        }

        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->email = $this->email;
        $user->birthday = $this->birthday;
        $user->phone = $this->phoneNumber;
        $user->telegram = $this->telegram;
        $user->information = $this->information;

        if ($user->save()) {

            $resultSaveUser = $user->user_id;
        }

        if ($resultSaveCategory && $resultSaveUser) {

            return true;
        }
    }


}
