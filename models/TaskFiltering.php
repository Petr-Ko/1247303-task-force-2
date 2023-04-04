<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \DateTime;


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


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>
                [
                    'pageSize' => 5,
                ],
            ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere(['category_id' => $this->category]);
        $query->andWhere(['executor_id' => $this->additionally]);

        if($this->period) {

            $interval = new DateTime("{$this->period} hours ago");

            $query->andFilterWhere(['>=', 'add_date', $interval->format('Y-m-d H:i:s')]);
        }


        return $dataProvider;
    }
}