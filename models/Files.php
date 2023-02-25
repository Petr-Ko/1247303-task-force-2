<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $file_id
 * @property string $add_date
 * @property string $path
 *
 * @property Users $file
 * @property TaskFiles[] $taskFiles
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_date'], 'safe'],
            [['path'], 'required'],
            [['path'], 'string', 'max' => 256],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['file_id' => 'avatar_file_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'add_date' => 'Add Date',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getFile()
    {
        return $this->hasOne(Users::class, ['avatar_file_id' => 'file_id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery|TaskFilesQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::class, ['file_id' => 'file_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
