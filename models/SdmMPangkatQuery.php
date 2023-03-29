<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMPangkat]].
 *
 * @see SdmMPangkat
 */
class SdmMPangkatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMPangkat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMPangkat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
