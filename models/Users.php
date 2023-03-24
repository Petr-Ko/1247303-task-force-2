<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $uses_id
 * @property string $add_date
 * @property string $first_name
 * @property string $last_name
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property string|null $telegram
 * @property int|null $city_id
 * @property string|null $information
 * @property string $birthday
 * @property int $avatar_file_id
 * @property int $is_executor
 *
 * @property Cities $cities
 * @property ExecutorCategories[] $executorCategories
 * @property Files $files
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_date', 'birthday'], 'safe'],
            [['first_name', 'last_name', 'password_hash', 'email', 'phone', 'birthday', 'avatar_file_id', 'is_executor'], 'required'],
            [['city_id', 'avatar_file_id', 'is_executor'], 'integer'],
            [['information'], 'string'],
            [['first_name', 'last_name', 'email', 'phone', 'telegram'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uses_id' => 'Uses ID',
            'add_date' => 'Add Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'city_id' => 'City ID',
            'information' => 'Information',
            'birthday' => 'Birthday',
            'avatar_file_id' => 'Avatar File ID',
            'is_executor' => 'Is Executor',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCities()
    {
        return $this->hasOne(Cities::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[ExecutorCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutorCategoriesQuery
     */
    public function getExecutorCategories()
    {
        return $this->hasMany(ExecutorCategories::class, ['executor_id' => 'uses_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|FilesQuery
     */
    public function getFiles()
    {
        return $this->hasOne(Files::class, ['file_id' => 'avatar_file_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponsesQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::class, ['executor_id' => 'uses_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'uses_id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Reviews::class, ['author_id' => 'uses_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['customer_id' => 'uses_id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'uses_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
