<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMKesatuan]].
 *
 * @see SdmMKesatuan
 */
class SdmMKesatuanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMKesatuan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMKesatuan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
