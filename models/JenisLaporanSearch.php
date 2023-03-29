<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JenisLaporan;

/**
 * SdmMAgamaSearch represents the model behind the search form of `app\models\SdmMAgama`.
 */
class JenisLaporanSearch extends SdmMAgama
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['agm_id', 'agm_aktif', 'agm_created_by', 'agm_updated_by', 'agm_deleted_by'], 'integer'],
            // [['agm_nama', 'agm_created_at', 'agm_updated_at', 'agm_deleted_at'], 'safe'],
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
        $query = JenisLaporan::find();

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
            'jl_nama' => $this->jl_nama,
        ]);

        return $dataProvider;
    }
}
