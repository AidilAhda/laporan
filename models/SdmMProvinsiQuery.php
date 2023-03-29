<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMProvinsi]].
 *
 * @see SdmMProvinsi
 */
class SdmMProvinsiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMProvinsi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMProvinsi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
