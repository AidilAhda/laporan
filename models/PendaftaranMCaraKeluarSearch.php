<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMCaraKeluar;

/**
 * PendaftaranMCaraKeluarSearch represents the model behind the search form of `app\models\PendaftaranMCaraKeluar`.
 */
class PendaftaranMCaraKeluarSearch extends PendaftaranMCaraKeluar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmck_kode', 'pmck_nama', 'pmck_created_at', 'pmck_updated_at', 'pmck_deleted_at'], 'safe'],
            [['pmck_aktif', 'pmck_created_by', 'pmck_updated_by', 'pmck_deleted_by'], 'integer'],
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
        $query = PendaftaranMCaraKeluar::find();

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
            'pmck_aktif' => $this->pmck_aktif,
            'pmck_created_at' => $this->pmck_created_at,
            'pmck_created_by' => $this->pmck_created_by,
            'pmck_updated_at' => $this->pmck_updated_at,
            'pmck_updated_by' => $this->pmck_updated_by,
            'pmck_deleted_at' => $this->pmck_deleted_at,
            'pmck_deleted_by' => $this->pmck_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmck_kode', $this->pmck_kode])
            ->andFilterWhere(['like', 'pmck_nama', $this->pmck_nama]);

        return $dataProvider;
    }
}
