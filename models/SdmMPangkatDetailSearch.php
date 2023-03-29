<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMPangkatDetail;

/**
 * SdmMPangkatDetailSearch represents the model behind the search form of `app\models\SdmMPangkatDetail`.
 */
class SdmMPangkatDetailSearch extends SdmMPangkatDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['smpd_id', 'smpd_smp_id', 'smpd_aktif', 'smpd_created_by', 'smpd_updated_by', 'smpd_deleted_by'], 'integer'],
            [['smpd_alias', 'smpd_nama', 'smpd_created_at', 'smpd_updated_at', 'smpd_deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SdmMPangkatDetail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'smpd_id' => $this->smpd_id,
            'smpd_smp_id' => $this->smpd_smp_id,
            'smpd_aktif' => $this->smpd_aktif,
            'smpd_created_at' => $this->smpd_created_at,
            'smpd_created_by' => $this->smpd_created_by,
            'smpd_updated_at' => $this->smpd_updated_at,
            'smpd_updated_by' => $this->smpd_updated_by,
            'smpd_deleted_at' => $this->smpd_deleted_at,
            'smpd_deleted_by' => $this->smpd_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'smpd_alias', $this->smpd_alias])
            ->andFilterWhere(['like', 'smpd_nama', $this->smpd_nama]);

        return $dataProvider;
    }
}
