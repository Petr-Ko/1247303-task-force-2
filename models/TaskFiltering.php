<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class TaskFiltering extends Model
{
    public $category;
    public $additionally;
    public $period;


    public function formName() {
        return 'filter';
    }

    public function rules()
    {
        return [
            [['category', 'additionally', 'period'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return
            [
                'category' => "Категории",
                'additionally' => 'Дополнительно',
                'period' => 'Период'
            ];
    }

    public function additional():array
    {
       return ['Без исполнителя'];
    }

    public function period():array
    {
        return
            [
                '1' => '1 час',
                '12' => '12 часов',
                '24' => '24 часа'
            ];
    }

    public function filtration($params)
    {
        $query = Tasks::find()->new();


        $dataProvider = new ActiveDataProvider(['query' => $query,   'pagination' => [
            'pageSize' => 10,
        ],]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['category_id' => "$this->category"])
              ->andFilterWhere(['executor_id' => "$this->additionally"]);

        return $dataProvider;
    }
}