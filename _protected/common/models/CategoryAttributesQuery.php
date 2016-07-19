<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CategoryAttributes]].
 *
 * @see CategoryAttributes
 */
class CategoryAttributesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CategoryAttributes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoryAttributes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}