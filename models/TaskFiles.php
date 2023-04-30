<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_files".
 *
 * @property int $task_file_id
 * @property int $task_id
 * @property int $file_id
 *
 * @property Files $file
 * @property Task $task
 */
class TaskFiles extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'file_id'], 'required'],
            [['task_id', 'file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['file_id' => 'file_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'task_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_file_id' => 'Task File ID',
            'task_id' => 'Task ID',
            'file_id' => 'File ID',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery|FilesQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::class, ['file_id' => 'file_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['task_id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskFilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskFilesQuery(get_called_class());
    }
}
