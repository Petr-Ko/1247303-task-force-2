<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ExecutorCategories]].
 *
 * @see ExecutorCategories
 */
class ExecutorCategoriesQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExecutorCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExecutorCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
