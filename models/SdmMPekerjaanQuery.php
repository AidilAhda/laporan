<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMPekerjaan]].
 *
 * @see SdmMPekerjaan
 */
class SdmMPekerjaanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMPekerjaan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMPekerjaan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
