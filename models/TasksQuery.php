<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tasks]].
 *
 * @see Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
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
     * @return Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
