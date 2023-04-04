<?php

namespace app\controllers;

use app\models\Users;
use yii\web\Controller;

class UserController extends Controller
{

    public function actionView($id)
    {
        $user = Users::findOne($id);


        return $this->render('view',['user' => $user,]);
    }

}