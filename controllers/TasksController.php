<?php

namespace app\controllers;


use app\models\TaskFiltering;
use app\models\Tasks;
use \app\models\Categories;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use \yii\widgets\ActiveForm;


class TasksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $model = new TaskFiltering();

        $categories = Categories::find()->select(['name','category_id'])->column();

        $tasks_new = Tasks::find()
            ->joinWith('category')
            ->where(['status' =>'new'])
            ->all();

        return $this->render('index', ['tasks_new' => $tasks_new, 'categories' => $categories, 'model' => $model]);
    }

}
