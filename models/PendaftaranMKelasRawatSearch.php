<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMKelasRawat;

/**
 * PendaftaranMKelasRawatSearch represents the model behind the search form of `app\models\PendaftaranMKelasRawat`.
 */
class PendaftaranMKelasRawatSearch extends PendaftaranMKelasRawat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kr_kode', 'kr_nama', 'kr_created_at', 'kr_updated_at', 'kr_deleted_at'], 'safe'],
            [['kr_aktif', 'kr_created_by', 'kr_updated_by', 'kr_deleted_by'], 'integer'],
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
        $query = PendaftaranMKelasRawat::find();

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
            'kr_aktif' => $this->kr_aktif,
            'kr_created_at' => $this->kr_created_at,
            'kr_created_by' => $this->kr_created_by,
            'kr_updated_at' => $this->kr_updated_at,
            'kr_updated_by' => $this->kr_updated_by,
            'kr_deleted_at' => $this->kr_deleted_at,
            'kr_deleted_by' => $this->kr_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kr_kode', $this->kr_kode])
            ->andFilterWhere(['like', 'kr_nama', $this->kr_nama]);

        return $dataProvider;
    }
}
