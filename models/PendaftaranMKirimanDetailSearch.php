<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMKirimanDetail;

/**
 * PendaftaranMKirimanDetailSearch represents the model behind the search form of `app\models\PendaftaranMKirimanDetail`.
 */
class PendaftaranMKirimanDetailSearch extends PendaftaranMKirimanDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmkd_kode', 'pmkd_pmkr_kode', 'pmkd_nama', 'pmkd_created_at', 'pmkd_updated_at', 'pmkd_deleted_at'], 'safe'],
            [['pmkd_aktif', 'pmkd_created_by', 'pmkd_updated_by', 'pmkd_deleted_by'], 'integer'],
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
        $query = PendaftaranMKirimanDetail::find();

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
            'pmkd_aktif' => $this->pmkd_aktif,
            'pmkd_created_at' => $this->pmkd_created_at,
            'pmkd_created_by' => $this->pmkd_created_by,
            'pmkd_updated_at' => $this->pmkd_updated_at,
            'pmkd_updated_by' => $this->pmkd_updated_by,
            'pmkd_deleted_at' => $this->pmkd_deleted_at,
            'pmkd_deleted_by' => $this->pmkd_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmkd_kode', $this->pmkd_kode])
            ->andFilterWhere(['like', 'pmkd_pmkr_kode', $this->pmkd_pmkr_kode])
            ->andFilterWhere(['like', 'pmkd_nama', $this->pmkd_nama]);

        return $dataProvider;
    }
}
