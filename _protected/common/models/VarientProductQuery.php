<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[VarientProduct]].
 *
 * @see VarientProduct
 */
class VarientProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VarientProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VarientProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
