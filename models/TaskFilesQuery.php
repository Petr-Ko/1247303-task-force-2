<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaskFiles]].
 *
 * @see TaskFiles
 */
class TaskFilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskFiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskFiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
