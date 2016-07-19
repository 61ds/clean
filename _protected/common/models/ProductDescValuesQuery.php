<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductDescValues]].
 *
 * @see ProductDescValues
 */
class ProductDescValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductDescValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductDescValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
