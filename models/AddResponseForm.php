<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddResponseForm extends Model
{
    public $price;
    public $description;


    public function rules()
    {
        return [
            [['price', 'description'], 'safe'],
            [['price', 'description'], 'required'],
            [['price', ], 'integer'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price' => 'Стоимость',
            'description' => 'Ваш комментарий',
        ];
    }

    public function CreateResponse($taskId)
    {
        $response = new Responses();
        $response->task_id = $taskId;
        $response->executor_id = Yii::$app->user->getId();
        $response->price = $this->price;
        $response->description = $this->description;
        $response->rejected = 0;

        if($response->save()) {

            return $response->response_id;
        }
    }
}
