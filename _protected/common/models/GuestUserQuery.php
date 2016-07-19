<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GuestUser]].
 *
 * @see GuestUser
 */
class GuestUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GuestUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GuestUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
