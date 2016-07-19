<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Pages]].
 *
 * @see Pages
 */
class PagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Pages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}