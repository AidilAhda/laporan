<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedisMTarifKamar;

/**
 * MedisMTarifKamarSearch represents the model behind the search form of `app\models\MedisMTarifKamar`.
 */
class MedisMTarifKamarSearch extends MedisMTarifKamar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tkr_id', 'tkr_kmr_id', 'tkr_skt_id', 'tkr_biaya', 'tkr_created_by', 'tkr_updated_by', 'tkr_deleted_by'], 'integer'],
            [['tkr_created_at', 'tkr_updated_at', 'tkr_deleted_at'], 'safe'],
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
        $query = MedisMTarifKamar::find();

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
            'tkr_id' => $this->tkr_id,
            'tkr_kmr_id' => $this->tkr_kmr_id,
            'tkr_skt_id' => $this->tkr_skt_id,
            'tkr_biaya' => $this->tkr_biaya,
            'tkr_created_at' => $this->tkr_created_at,
            'tkr_created_by' => $this->tkr_created_by,
            'tkr_updated_at' => $this->tkr_updated_at,
            'tkr_updated_by' => $this->tkr_updated_by,
            'tkr_deleted_at' => $this->tkr_deleted_at,
            'tkr_deleted_by' => $this->tkr_deleted_by,
        ]);

        return $dataProvider;
    }
}
