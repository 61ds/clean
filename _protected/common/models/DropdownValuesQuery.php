<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DropdownValues]].
 *
 * @see DropdownValues
 */
class DropdownValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return DropdownValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DropdownValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}