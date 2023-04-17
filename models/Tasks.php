<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $task_id
 * @property string $add_date
 * @property string $status
 * @property int $customer_id
 * @property string $title
 * @property string $description
 * @property string $latitude
 * @property string $longitude
 * @property string $end_date
 * @property int|null $price
 * @property int $category_id
 * @property int|null $executor_id
 *
 * @property Categories $category
 * @property User $customer
 * @property User $executor
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property TaskFiles[] $taskFiles
 */
class Tasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_date', 'end_date'], 'safe'],
            [['status', 'customer_id', 'title', 'description', 'latitude', 'longitude', 'category_id'], 'required'],
            [['customer_id', 'price', 'category_id', 'executor_id'], 'integer'],
            [['description'], 'string'],
            [['status', 'title', 'latitude', 'longitude'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'user_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'add_date' => 'Add Date',
            'status' => 'Status',
            'customer_id' => 'Customer ID',
            'title' => 'Title',
            'description' => 'Description',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'end_date' => 'End Date',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'executor_id' => 'Executor ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['user_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['user_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponsesQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::class, ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery|TaskFilesQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::class, ['task_id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }
}
