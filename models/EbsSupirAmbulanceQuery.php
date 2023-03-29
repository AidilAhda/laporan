<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsSupirAmbulance]].
 *
 * @see EbsSupirAmbulance
 */
class EbsSupirAmbulanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsSupirAmbulance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsSupirAmbulance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
