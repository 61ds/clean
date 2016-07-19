<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Sizewidth]].
 *
 * @see Sizewidth
 */
class SizewidthQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Sizewidth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Sizewidth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
