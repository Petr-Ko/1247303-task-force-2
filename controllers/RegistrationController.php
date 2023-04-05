<?php

namespace app\controllers;

use app\models\Cities;
use app\models\UserRegistration;
use Yii;
use yii\web\Controller;

class RegistrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $registrationForm = new UserRegistration();

        $registrationForm->AddUser(Yii::$app->request->post());


        $cities = Cities::find()->select('name')->indexBy('city_id')->column();

        return $this->render('index',['registrationForm' => $registrationForm, 'cities' => $cities]);
    }



}