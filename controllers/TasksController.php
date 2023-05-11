<?php

namespace app\controllers;


use app\models\AddResponseForm;
use app\models\addTaskForm;
use app\models\Files;
use app\models\ResponseActionsForm;
use app\models\TaskFiles;
use app\models\TaskFiltering;
use app\models\Categories;
use app\models\Task;
use TaskForce\classes\actions\Task\RespondAction;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;


class TasksController extends SecuredController
{
    private function categories() {

        return Categories::find()->select(['name'])->indexBy('category_id')->column();
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
     * Displays page All Tasks.
     *
     * @return string
     */
    public function actionIndex()
    {
        $filterForm  = new TaskFiltering();

        $provider = $filterForm->filtration(Yii::$app->request->get());

        $tasks_new = $provider->getModels();

        $pages = $provider->getPagination();

        return $this->render('index',
            [
                'tasks_new' => $tasks_new,
                'categories' => $this->categories(),
                'filterForm' => $filterForm,
                'pages' => $pages,
            ]);
    }

    /**
     * Displays page One Task.
     *
     * @return string
     */
    public function actionView($id)
    {

        $task = Task::findOne($id);

        $responses = $task->responses;

        $AddResponseForm = new AddResponseForm();

        if($AddResponseForm->load(Yii::$app->request->post()) && $AddResponseForm->validate()) {

            if($AddResponseForm->CreateResponse($id)) return $this->redirect(Url::to('/tasks/view/' . $id));
        }

        return $this->render('view',['task' => $task,'responses' => $responses,'AddResponseForm' => $AddResponseForm]);
    }

    public function actionAdd()
    {
        if(Yii::$app->user->identity->is_executor) {

            return $this->redirect('index');
        }

        $addForm = new AddTaskForm();

        if($addForm->load(Yii::$app->request->post()) && $addForm->validate()) {

            $newTaskId = $addForm->CreateTask();

            $addForm->files = UploadedFile::getInstances($addForm, 'files');

            $filePaths = $addForm->upload();

            if(count($filePaths) & isset($newTaskId)) {

                $addForm->NewTaskFiles($filePaths, $newTaskId);
            }

            if(isset($newTaskId)) {


            }
        }

        return $this->render('add',['addForm' => $addForm, 'categories' => $this->categories(),]);
    }


}
