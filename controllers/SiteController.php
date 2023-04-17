<?php

namespace app\controllers;

use app\models\Categories;
use app\models\User;
use Yii;
use app\models\ContactForm;

class SiteController extends SecuredController
{


//    public function init()
//    {
//        parent::init();
//
//        $user = null;
//
//        if ($id = Yii::$app->user->getId()) {
//
//            $user = User::findOne($id);
//
//        }
//    }

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

        $executors = User::find()
            ->joinWith('cities')
            ->where(['is_executor' => 1])
            ->asArray()
            ->all();

        $category_names = Categories::find()
            ->select('name')
            ->column();

        return $this->render('index', ['category_names' => $category_names, 'executors' => $executors],);
    }

}
