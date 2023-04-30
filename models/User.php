<?php

namespace app\models;

use DateTime;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
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
 * @property Reviews[] $reviewsAuthor
 * @property Task[] $tasks
 * @property Task[] $tasksExecutor
 */
class User extends ActiveRecord implements IdentityInterface
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
            [['first_name', 'last_name', 'email', 'password', 'password_repeat', 'city_id', 'is_executor','add_date', 'birthday'], 'safe'],
            [['first_name', 'last_name', 'password_hash', 'email', 'is_executor'], 'required'],
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
            'user_id' => 'User ID',
            'add_date' => 'Дата регистрации',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'phone' => 'Телефон',
            'telegram' => 'Telegram',
            'city_id' => 'Город',
            'information' => 'Information',
            'birthday' => 'Дата рождения',
            'avatar_file_id' => 'Avatar File ID',
            'is_executor' => 'я собираюсь откликаться на заказы',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
        ];
    }

    /**
     *
     */
    public function getAge():int
    {
        $today = new DateTime('now');

        $birthday = new DateTime($this->birthday);

        $age = $today->diff($birthday)->format("%y");

        return $age;
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
        return $this->hasMany(ExecutorCategories::class, ['executor_id' => 'user_id']);
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
        return $this->hasMany(Responses::class, ['executor_id' => 'user_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviewsAuthor()
    {
        return $this->hasMany(Reviews::class, ['author_id' => 'user_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'user_id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasksExecutor()
    {
        return $this->hasMany(Task::class, ['executor_id' => 'user_id']);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
