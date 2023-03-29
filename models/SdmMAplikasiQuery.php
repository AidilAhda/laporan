<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMAplikasi]].
 *
 * @see SdmMAplikasi
 */
class SdmMAplikasiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMAplikasi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMAplikasi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
