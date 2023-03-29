<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsSupirAmbulance;

/**
 * EbsSupirAmbulanceSearch represents the model behind the search form of `app\models\EbsSupirAmbulance`.
 */
class EbsSupirAmbulanceSearch extends EbsSupirAmbulance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spnce_id', 'spnce_no_identitas', 'spnce_status', 'spnce_created_by', 'spnce_updated_by', 'spnce_deleted_by'], 'integer'],
            [['spnce_nama', 'spnce_tgl_lahir', 'spnce_alamat', 'spnce_no_hp', 'spnce_created_at', 'spnce_updated_at', 'spnce_deleted_at'], 'safe'],
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
        $query = EbsSupirAmbulance::find();

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
            'spnce_id' => $this->spnce_id,
            'spnce_no_identitas' => $this->spnce_no_identitas,
            'spnce_tgl_lahir' => $this->spnce_tgl_lahir,
            'spnce_status' => $this->spnce_status,
            'spnce_created_at' => $this->spnce_created_at,
            'spnce_created_by' => $this->spnce_created_by,
            'spnce_updated_at' => $this->spnce_updated_at,
            'spnce_updated_by' => $this->spnce_updated_by,
            'spnce_deleted_at' => $this->spnce_deleted_at,
            'spnce_deleted_by' => $this->spnce_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'spnce_nama', $this->spnce_nama])
            ->andFilterWhere(['like', 'spnce_alamat', $this->spnce_alamat])
            ->andFilterWhere(['like', 'spnce_no_hp', $this->spnce_no_hp]);

        return $dataProvider;
    }
}
