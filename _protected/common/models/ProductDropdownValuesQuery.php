<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductDropdownValues]].
 *
 * @see ProductDropdownValues
 */
class ProductDropdownValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductDropdownValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductDropdownValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
