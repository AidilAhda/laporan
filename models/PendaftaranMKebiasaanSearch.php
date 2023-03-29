<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMKebiasaan;

/**
 * PendaftaranMKebiasaanSearch represents the model behind the search form of `app\models\PendaftaranMKebiasaan`.
 */
class PendaftaranMKebiasaanSearch extends PendaftaranMKebiasaan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmk_id', 'pmk_aktif', 'pmk_created_by', 'pmk_updated_by', 'pmk_deleted_by'], 'integer'],
            [['pmk_nama', 'pmk_created_at', 'pmk_updated_at', 'pmk_deleted_at'], 'safe'],
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
        $query = PendaftaranMKebiasaan::find();

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
            'pmk_id' => $this->pmk_id,
            'pmk_aktif' => $this->pmk_aktif,
            'pmk_created_at' => $this->pmk_created_at,
            'pmk_created_by' => $this->pmk_created_by,
            'pmk_updated_at' => $this->pmk_updated_at,
            'pmk_updated_by' => $this->pmk_updated_by,
            'pmk_deleted_at' => $this->pmk_deleted_at,
            'pmk_deleted_by' => $this->pmk_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmk_nama', $this->pmk_nama]);

        return $dataProvider;
    }
}
