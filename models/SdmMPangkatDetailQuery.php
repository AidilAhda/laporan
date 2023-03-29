<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMPangkatDetail]].
 *
 * @see SdmMPangkatDetail
 */
class SdmMPangkatDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMPangkatDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMPangkatDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
