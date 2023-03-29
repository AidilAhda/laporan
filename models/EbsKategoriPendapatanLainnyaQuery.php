<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsKategoriPendapatanLainnya]].
 *
 * @see EbsKategoriPendapatanLainnya
 */
class EbsKategoriPendapatanLainnyaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsKategoriPendapatanLainnya[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsKategoriPendapatanLainnya|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
