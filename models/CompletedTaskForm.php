<?php

namespace app\models;

use yii\base\Model;

class CompletedTaskForm extends Model
{
    public $score;
    public $text;


    public function rules()
    {
        return [
            [['score', 'text'], 'safe'],
            [['score', 'text'], 'required'],
            [['score', ], 'integer'],
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'score' => 'Оценка работы',
            'text' => 'Ваш комментарий',
        ];
    }

    public function CloseTask(Task $task)
    {

        $review = new Reviews();
        $review->task_id = $task->task_id;
        $review->author_id = $task->customer_id;
        $review->score = $this->score;
        $review->text = $this->text;
        $review->user_id =$task->executor_id;


        if($review->save()) {

            $task->status = Task::STATUS_DONE;

            if($task->save()) {

                return $review->review_id;
            }
        }

    }

}
