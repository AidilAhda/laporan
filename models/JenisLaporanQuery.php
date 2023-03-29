<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMAgama]].
 *
 * @see SdmMAgama
 */
class JenisLaporanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JenisLaporan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JenisLaporan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
