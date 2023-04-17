<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LandingController extends Controller
{

    public $layout = 'landing';
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

    public function actionIndex()
    {


        $loginForm = new LoginForm();

        if(Yii::$app->request->getIsPost()) {

            $loginForm->load(Yii::$app->request->post());


            if(Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }


            if($loginForm->validate()){

                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }

        }

        return  $this->render('index', ['loginForm' => $loginForm]);
    }

}