<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMKecamatan;

/**
 * SdmMKecamatanSearch represents the model behind the search form of `app\models\SdmMKecamatan`.
 */
class SdmMKecamatanSearch extends SdmMKecamatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kec_kode', 'kec_kab_kode', 'kec_aktif', 'kec_created_by', 'kec_updated_by', 'kec_deleted_by'], 'integer'],
            [['kec_nama', 'kec_created_at', 'kec_updated_at', 'kec_deleted_at'], 'safe'],
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
        $query = SdmMKecamatan::find();

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
            'kec_kode' => $this->kec_kode,
            'kec_kab_kode' => $this->kec_kab_kode,
            'kec_aktif' => $this->kec_aktif,
            'kec_created_at' => $this->kec_created_at,
            'kec_created_by' => $this->kec_created_by,
            'kec_updated_at' => $this->kec_updated_at,
            'kec_updated_by' => $this->kec_updated_by,
            'kec_deleted_at' => $this->kec_deleted_at,
            'kec_deleted_by' => $this->kec_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kec_nama', $this->kec_nama]);

        return $dataProvider;
    }
}
