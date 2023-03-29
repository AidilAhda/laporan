<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsPembayaranPasien]].
 *
 * @see EbsPembayaranPasien
 */
class EbsPembayaranPasienQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsPembayaranPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsPembayaranPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
