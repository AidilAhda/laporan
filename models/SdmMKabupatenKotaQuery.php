<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMKabupatenKota]].
 *
 * @see SdmMKabupatenKota
 */
class SdmMKabupatenKotaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMKabupatenKota[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMKabupatenKota|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
