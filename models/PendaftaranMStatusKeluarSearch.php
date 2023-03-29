<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMStatusKeluar;

/**
 * PendaftaranMStatusKeluarSearch represents the model behind the search form of `app\models\PendaftaranMStatusKeluar`.
 */
class PendaftaranMStatusKeluarSearch extends PendaftaranMStatusKeluar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmsk_kode', 'pmsk_nama', 'pmsk_created_at', 'pmsk_updated_at', 'pmsk_deleted_at'], 'safe'],
            [['pmsk_aktif', 'pmsk_created_by', 'pmsk_updated_by', 'pmsk_deleted_by'], 'integer'],
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
        $query = PendaftaranMStatusKeluar::find();

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
            'pmsk_aktif' => $this->pmsk_aktif,
            'pmsk_created_at' => $this->pmsk_created_at,
            'pmsk_created_by' => $this->pmsk_created_by,
            'pmsk_updated_at' => $this->pmsk_updated_at,
            'pmsk_updated_by' => $this->pmsk_updated_by,
            'pmsk_deleted_at' => $this->pmsk_deleted_at,
            'pmsk_deleted_by' => $this->pmsk_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmsk_kode', $this->pmsk_kode])
            ->andFilterWhere(['like', 'pmsk_nama', $this->pmsk_nama]);

        return $dataProvider;
    }
}
