<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Testimonial]].
 *
 * @see Testimonial
 */
class TestimonialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Testimonial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Testimonial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}