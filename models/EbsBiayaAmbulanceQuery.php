<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsBiayaAmbulance]].
 *
 * @see EbsBiayaAmbulance
 */
class EbsBiayaAmbulanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsBiayaAmbulance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsBiayaAmbulance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
