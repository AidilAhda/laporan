<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMPegawai]].
 *
 * @see SdmMPegawai
 */
class SdmMPegawaiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMPegawai[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMPegawai|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
