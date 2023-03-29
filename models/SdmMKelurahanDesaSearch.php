<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMKelurahanDesa;

/**
 * SdmMKelurahanDesaSearch represents the model behind the search form of `app\models\SdmMKelurahanDesa`.
 */
class SdmMKelurahanDesaSearch extends SdmMKelurahanDesa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kel_kode', 'kel_kec_kode', 'kel_aktif', 'kel_created_by', 'kel_updated_by', 'kel_deleted_by'], 'integer'],
            [['kel_nama', 'kel_created_at', 'kel_updated_at', 'kel_deleted_at'], 'safe'],
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
        $query = SdmMKelurahanDesa::find();

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
            'kel_kode' => $this->kel_kode,
            'kel_kec_kode' => $this->kel_kec_kode,
            'kel_aktif' => $this->kel_aktif,
            'kel_created_at' => $this->kel_created_at,
            'kel_created_by' => $this->kel_created_by,
            'kel_updated_at' => $this->kel_updated_at,
            'kel_updated_by' => $this->kel_updated_by,
            'kel_deleted_at' => $this->kel_deleted_at,
            'kel_deleted_by' => $this->kel_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kel_nama', $this->kel_nama]);

        return $dataProvider;
    }
}
