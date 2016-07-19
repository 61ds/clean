<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Attributes]].
 *
 * @see Attributes
 */
class AttributesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Attributes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Attributes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}