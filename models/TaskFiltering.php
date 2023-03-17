<?php

namespace app\models;

use yii\base\Model;


class TaskFiltering extends Model
{
    public $category;
    public $additionally;
    public $period;

    public function attributeLabels()
    {
        return
            [
                'category' => "Категории",
                'additionally' => 'Дополнительно',
                'period' => 'Период'
            ];
    }

    public function noExecutors():array
    {
       return ['Без исполнителя'];
    }

    public function period():array
    {
        return
            [
                '1 час',
                '12 часов',
                '24 часа'
            ];
    }
}