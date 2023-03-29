<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMKabupatenKota;

/**
 * SdmMKabupatenKotaSearch represents the model behind the search form of `app\models\SdmMKabupatenKota`.
 */
class SdmMKabupatenKotaSearch extends SdmMKabupatenKota
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kab_kode', 'kab_prv_kode', 'kab_aktif', 'kab_created_by', 'kab_updated_by', 'kab_deleted_by'], 'integer'],
            [['kab_nama', 'kab_created_at', 'kab_updated_at', 'kab_deleted_at'], 'safe'],
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
        $query = SdmMKabupatenKota::find();

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
            'kab_kode' => $this->kab_kode,
            'kab_prv_kode' => $this->kab_prv_kode,
            'kab_aktif' => $this->kab_aktif,
            'kab_created_at' => $this->kab_created_at,
            'kab_created_by' => $this->kab_created_by,
            'kab_updated_at' => $this->kab_updated_at,
            'kab_updated_by' => $this->kab_updated_by,
            'kab_deleted_at' => $this->kab_deleted_at,
            'kab_deleted_by' => $this->kab_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kab_nama', $this->kab_nama]);

        return $dataProvider;
    }
}
