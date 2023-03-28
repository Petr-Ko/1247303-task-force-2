<?php

namespace app\controllers;


use app\models\TaskFiltering;
use app\models\Categories;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;



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
        $filterForm  = new TaskFiltering();

        $provider = $filterForm->filtration(Yii::$app->request->get());

        $tasks_new = $provider->getModels();

        $pages = $provider->getPagination();

        $categories = Categories::find()->select(['name'])->indexBy('category_id')->column();

        return $this->render('index',
            [
                'tasks_new' => $tasks_new,
                'categories' => $categories,
                'filterForm' => $filterForm,
                'pages' => $pages,
            ]);
    }

}
