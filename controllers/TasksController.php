<?php

namespace app\controllers;


use app\models\addTaskForm;
use app\models\Files;
use app\models\TaskFiles;
use app\models\TaskFiltering;
use app\models\Categories;
use app\models\Task;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;


class TasksController extends SecuredController
{
    private function categoteries() {

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

        return $this->render('index',
            [
                'tasks_new' => $tasks_new,
                'categories' => $this->categoteries(),
                'filterForm' => $filterForm,
                'pages' => $pages,
            ]);
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);

        return $this->render('view',['task' => $task,]);
    }

    public function actionAdd()
    {
        if(Yii::$app->user->identity->is_executor) {

            return $this->redirect('index');
        }

        $addForm = new AddTaskForm();

        if($addForm->load(Yii::$app->request->post()) && $addForm->validate()) {

            $resultAddTask = false;

            $task = new Task();
            $task->status = 'new';
            $task->customer_id = Yii::$app->user->getId();
            $task->title = $addForm->title;
            $task->description = $addForm->description;
            $task->latitude = '.';
            $task->longitude = '.';
            $task->end_date = $addForm->end_date;
            $task->price = (integer) $addForm->price;
            $task->category_id = $addForm->category;


            if($task->save()){

                $resultAddTask = true;
            }

            $addForm->files = UploadedFile::getInstances($addForm, 'files');

            $filePaths = $addForm->upload();

            if(count($filePaths)) {

                $file = new Files();

                $taskFiles = new TaskFiles();

                foreach ($filePaths as $filePath) {

                    $file->path = $filePath;

                    if($file->save()) {

                        $taskFiles->task_id = $task->task_id;
                        $taskFiles->file_id = $file->file_id;
                        $taskFiles->save();
                    }
                }
            }

            if($resultAddTask) {

                return $this->redirect(Url::to('/tasks/view/' . $task->task_id));
            }
        }

        return $this->render('add',['addForm' => $addForm, 'categories' => $this->categoteries(),]);
    }


}
