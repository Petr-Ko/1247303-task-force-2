<?php

namespace app\controllers;

use DateTime;
use app\models\AddResponseForm;
use app\models\addTaskForm;
use app\models\CompletedTaskForm;
use app\models\Responses;
use app\models\TaskFiltering;
use app\models\Categories;
use app\models\Task;
use app\models\User;
use TaskForce\actions\Task\RespondAction;
use TaskForce\geoinformation\GeoInformationYandex;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    private function categories()
    {

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

        $tasksNew = $provider->getModels();

        $pages = $provider->getPagination();

        return $this->render(
            'index',
            [
                'tasksNew' => $tasksNew,
                'categories' => $this->categories(),
                'filterForm' => $filterForm,
                'pages' => $pages,
            ]
        );
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

        $addResponseForm = new AddResponseForm();

        $completedTaskForm = new CompletedTaskForm();

        $taskAddress = new GeoInformationYandex();

        $taskAddress->setCoordinates($task->latitude, $task->longitude);

        if ($addResponseForm->load(Yii::$app->request->post()) && $addResponseForm->validate()) {

            if ($addResponseForm->CreateResponse($id)) {

                return $this->redirect(Url::to('/tasks/view/' . $id));
            }
        }

        if($completedTaskForm->load(Yii::$app->request->post()) && $completedTaskForm->validate()) {

            if ($completedTaskForm->CloseTask($task)) {

                return $this->redirect('/');
            }
        }

        return $this->render(
            'view',
            [
                'task' => $task,
                'taskAddress' => $taskAddress,
                'responses' => $responses,
                'addResponseForm' => $addResponseForm,
                'completedTaskForm' => $completedTaskForm,
            ]
        );
    }

    public function actionAdd()
    {
        if (Yii::$app->user->identity->is_executor) {

            return $this->redirect('index');
        }

        $addForm = new AddTaskForm();

        if ($addForm->load(Yii::$app->request->post()) && $addForm->validate()) {

            $newTaskId = $addForm->CreateTask();

            $addForm->files = UploadedFile::getInstances($addForm, 'files');

            $filePaths = $addForm->upload();

            if (count($filePaths) && $newTaskId) {

                $addForm->NewTaskFiles($filePaths, $newTaskId);
            }

            if ($newTaskId) {

                return $this->redirect(Url::to('/tasks/view/' . $newTaskId));

            }
        }

        return $this->render('add', ['addForm' => $addForm, 'categories' => $this->categories(),]);
    }

    public function actionRefused()
    {
        $taskId = Yii::$app->request->post('task_id', null);

        if ($taskId) {

            $task = Task::findOne($taskId);
            $task->status = Task::STATUS_FAILED;

            if($task->save()) {
                return $this->redirect('/');
            }
        }
    }

    public function actionResponse()
    {

        $responseId = Yii::$app->request->post('response_id', null);

        $typeAction = Yii::$app->request->post('action', null);

        $response = Responses::findOne($responseId);


        if ($responseId && $typeAction === 'rejected') {

            $response->rejected = 1;

            if($response->save()) {

                return $this->redirect(Url::to('/tasks/view/' . $response->task_id));
            }
        }

        if ($responseId && $typeAction === 'accepted') {

            $task = Task::findOne($response->task_id);

            $respondAction = new RespondAction();

            if($respondAction->acceptResponse($task, $response)) {

                return $this->redirect(Url::to('/tasks/view/' . $task->task_id));
            }
        }
    }

    public function actionMy($status)
    {
        $tasks = null;

        $currentUserId = Yii::$app->user->identity;

        $is_executor = $currentUserId->is_executor;


        if ($status === 'new') {

            $tasks = Task::find()->where(['task_id' => $currentUserId, 'status' => Task::STATUS_NEW])->all();

        }

        if ($status === 'progress') {

            $tasks = Task::find()->where(['task_id' => $currentUserId, 'status' => Task::STATUS_IN_PROGRESS])->all();

        }

        if ($status === 'done') {

            $tasks = Task::find()->where(['task_id' => $currentUserId, 'status' => Task::STATUS_DONE])->all();

        }

        if ($status === 'overdue') {

            $tasks = Task::find()
                ->where(
                    [
                        'task_id' => $currentUserId,
                        'status' => Task::STATUS_IN_PROGRESS,
                    ])
                ->andFilterWhere([
                    '<=', 'end_date', date_format(new DateTime('now'), 'Y-m-d')
                ])
                ->all();
        }

        return $this->render('my', ['tasks' => $tasks, 'is_executor' => $is_executor, ]);

    }


}
