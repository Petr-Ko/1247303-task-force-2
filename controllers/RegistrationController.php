<?php

namespace app\controllers;

use app\models\Cities;
use app\models\UserRegistrationForm;
use app\models\User;
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
        $registrationForm = new UserRegistrationForm();

        if($registrationForm->load(Yii::$app->request->post()) && $registrationForm->validate()) {

            $user = new User();

            $user->first_name =  $registrationForm->first_name;
            $user->last_name = $registrationForm->last_name;
            $user->email = $registrationForm->email;
            $user->city_id = $registrationForm->city_id;
            $user->is_executor = $registrationForm->is_executor;
            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($registrationForm->password);

            if($user->save()){

                return $this->goHome();
            }
        }

        $cities = Cities::find()->select('name')->indexBy('city_id')->column();

        return $this->render('index',['registrationForm' => $registrationForm, 'cities' => $cities]);
    }



}