<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMProvinsi;

/**
 * SdmMProvinsiSearch represents the model behind the search form of `app\models\SdmMProvinsi`.
 */
class SdmMProvinsiSearch extends SdmMProvinsi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prv_kode', 'prv_aktif', 'prv_created_by', 'prv_updated_by', 'prv_deleted_by'], 'integer'],
            [['prv_nama', 'prv_created_at', 'prv_updated_at', 'prv_deleted_at'], 'safe'],
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
        $query = SdmMProvinsi::find();

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
            'prv_kode' => $this->prv_kode,
            'prv_aktif' => $this->prv_aktif,
            'prv_created_at' => $this->prv_created_at,
            'prv_created_by' => $this->prv_created_by,
            'prv_updated_at' => $this->prv_updated_at,
            'prv_updated_by' => $this->prv_updated_by,
            'prv_deleted_at' => $this->prv_deleted_at,
            'prv_deleted_by' => $this->prv_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'prv_nama', $this->prv_nama]);

        return $dataProvider;
    }
}
