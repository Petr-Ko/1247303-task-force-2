<?php

namespace app\models;

use yii\base\Model;

class ResponseActionsForm extends Model
{
    public $accept;
    public $reject;

    public function formName()
    {
        return 'response-action';
    }

    public function rules()
    {
        return [
            [['accept', 'reject',], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'accept' => 'Принять',
            'reject' => 'Отклонить',
        ];
    }

}