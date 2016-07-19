<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Entity]].
 *
 * @see Entity
 */
class EntityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Entity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Entity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}