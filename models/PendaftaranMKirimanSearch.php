<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMKiriman;

/**
 * PendaftaranMKirimanSearch represents the model behind the search form of `app\models\PendaftaranMKiriman`.
 */
class PendaftaranMKirimanSearch extends PendaftaranMKiriman
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmkr_kode', 'pmkr_nama', 'pmkr_created_at', 'pmkr_updated_at', 'pmkr_deleted_at'], 'safe'],
            [['pmkr_aktif', 'pmkr_created_by', 'pmkr_updated_by', 'pmkr_deleted_by'], 'integer'],
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
        $query = PendaftaranMKiriman::find();

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
            'pmkr_aktif' => $this->pmkr_aktif,
            'pmkr_created_at' => $this->pmkr_created_at,
            'pmkr_created_by' => $this->pmkr_created_by,
            'pmkr_updated_at' => $this->pmkr_updated_at,
            'pmkr_updated_by' => $this->pmkr_updated_by,
            'pmkr_deleted_at' => $this->pmkr_deleted_at,
            'pmkr_deleted_by' => $this->pmkr_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmkr_kode', $this->pmkr_kode])
            ->andFilterWhere(['like', 'pmkr_nama', $this->pmkr_nama]);

        return $dataProvider;
    }
}
