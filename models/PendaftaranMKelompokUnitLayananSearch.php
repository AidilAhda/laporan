<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMKelompokUnitLayanan;

/**
 * PendaftaranMKelompokUnitLayananSearch represents the model behind the search form of `app\models\PendaftaranMKelompokUnitLayanan`.
 */
class PendaftaranMKelompokUnitLayananSearch extends PendaftaranMKelompokUnitLayanan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kul_id', 'kul_unit_id', 'kul_type', 'kul_aktif', 'kul_created_by', 'kul_updated_by', 'kul_deleted_by'], 'integer'],
            [['kul_tarif_tindakan_id', 'kul_created_at', 'kul_updated_at', 'kul_deleted_at'], 'safe'],
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
        $query = PendaftaranMKelompokUnitLayanan::find();

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
            'kul_id' => $this->kul_id,
            'kul_unit_id' => $this->kul_unit_id,
            'kul_type' => $this->kul_type,
            'kul_aktif' => $this->kul_aktif,
            'kul_created_at' => $this->kul_created_at,
            'kul_created_by' => $this->kul_created_by,
            'kul_updated_at' => $this->kul_updated_at,
            'kul_updated_by' => $this->kul_updated_by,
            'kul_deleted_at' => $this->kul_deleted_at,
            'kul_deleted_by' => $this->kul_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kul_tarif_tindakan_id', $this->kul_tarif_tindakan_id]);

        return $dataProvider;
    }
}
