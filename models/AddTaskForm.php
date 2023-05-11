<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;

class AddTaskForm extends Model
{
    public $title;
    public $description;
    public $category;
    public $location;
    public $price;
    public $end_date;
    public $files;

    public function formName()
    {
        return 'add-task';
    }


    public function rules()
    {
        return [
            [['title', 'description', 'category', 'price', 'location', 'files'], 'safe'],
            [['end_date'], 'date', 'format' => 'php:Y-m-d', 'min' => date_format(new DateTime('now'), 'Y-m-d')],
            [['title', 'description', 'category', 'price'], 'required'],
            [['price'], 'integer', 'min' => 1],
            [['description'], 'string', 'max' => 300],
            [['title'], 'string', 'max' => 50],
            [['files'], 'file', 'maxFiles' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Опишите суть работы',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'location' => 'Локация',
            'price' => 'Бюджет',
            'end_date' => 'Срок исполнения',
            'files' => 'Файлы',
        ];
    }

    public function CreateTask()
    {
        $task = new Task();
        $task->status = 'new';
        $task->customer_id = Yii::$app->user->getId();
        $task->title = $this->title;
        $task->description = $this->description;
        $task->latitude = '.';
        $task->longitude = '.';
        $task->end_date = $this->end_date;
        $task->price = (integer) $this->price;
        $task->category_id = $this->category;

        if($task->save()) return $task->task_id;

    }

    public function NewTaskFiles(array $filePaths, int $newTaskId)
    {
        $file = new Files();

        $taskFiles = new TaskFiles();

        foreach ($filePaths as $filePath) {

            $file->path = $filePath;

            if($file->save()) {

                $taskFiles->task_id = $newTaskId;
                $taskFiles->file_id = $file->file_id;
                $taskFiles->save();
            }
        }
    }

    public function upload()
    {
        $filePaths = array();

        foreach ($this->files as $file) {

            $randName = mt_rand(10000, 1000000);

            $filePath = 'uploads/' . $randName . '.' . $file->extension;

            if($file->saveAs($filePath)) {

                $filePaths[] = $filePath;
            }

        }

        return $filePaths;
    }
}