<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BillingAddress]].
 *
 * @see BillingAddress
 */
class BillingAddressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BillingAddress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BillingAddress|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
