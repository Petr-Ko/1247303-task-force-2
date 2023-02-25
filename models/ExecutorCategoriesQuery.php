<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExecutorCategories]].
 *
 * @see ExecutorCategories
 */
class ExecutorCategoriesQuery extends \yii\db\ActiveQuery
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
