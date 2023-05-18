<?php

namespace app\controllers;

use app\models\Reviews;
use app\models\User;
use yii\web\Controller;

class UserController extends SecuredController
{

    public function actionView($id)
    {
        $user = User::findOne($id);

        $reviews = $user->reviews;

        return $this->render('view',['user' => $user,'reviews' => $reviews]);
    }

}