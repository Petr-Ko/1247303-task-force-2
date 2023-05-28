<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TasksQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function new()
    {
        return $this->andWhere('[[status]]="new"');
    }

    public function done()
    {
        return $this->andWhere('[[status]]="done"');
    }

    public function failed()
    {
        return $this->andWhere('[[status]]="failed"');
    }



    /**
     * {@inheritdoc}
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
