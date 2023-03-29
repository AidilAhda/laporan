<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMDebiturDetail;

/**
 * PendaftaranMDebiturDetailSearch represents the model behind the search form of `app\models\PendaftaranMDebiturDetail`.
 */
class PendaftaranMDebiturDetailSearch extends PendaftaranMDebiturDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmdd_kode', 'pmdd_pmd_kode', 'pmdd_nama', 'pmdd_created_at', 'pmdd_updated_at', 'pmdd_deleted_at'], 'safe'],
            [['pmdd_aktif', 'pmdd_created_by', 'pmdd_updated_by', 'pmdd_deleted_by'], 'integer'],
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
        $query = PendaftaranMDebiturDetail::find();

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
            'pmdd_aktif' => $this->pmdd_aktif,
            'pmdd_created_at' => $this->pmdd_created_at,
            'pmdd_created_by' => $this->pmdd_created_by,
            'pmdd_updated_at' => $this->pmdd_updated_at,
            'pmdd_updated_by' => $this->pmdd_updated_by,
            'pmdd_deleted_at' => $this->pmdd_deleted_at,
            'pmdd_deleted_by' => $this->pmdd_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmdd_kode', $this->pmdd_kode])
            ->andFilterWhere(['like', 'pmdd_pmd_kode', $this->pmdd_pmd_kode])
            ->andFilterWhere(['like', 'pmdd_nama', $this->pmdd_nama]);

        return $dataProvider;
    }
}
