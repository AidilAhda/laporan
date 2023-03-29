<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMPekerjaan;

/**
 * SdmMPekerjaanSearch represents the model behind the search form of `app\models\SdmMPekerjaan`.
 */
class SdmMPekerjaanSearch extends SdmMPekerjaan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pkj_id', 'pkj_aktif', 'pkj_created_by', 'pkj_updated_by', 'pkj_deleted_by'], 'integer'],
            [['pkj_nama', 'pkj_created_at', 'pkj_updated_at', 'pkj_deleted_at'], 'safe'],
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
        $query = SdmMPekerjaan::find();

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
            'pkj_id' => $this->pkj_id,
            'pkj_aktif' => $this->pkj_aktif,
            'pkj_created_at' => $this->pkj_created_at,
            'pkj_created_by' => $this->pkj_created_by,
            'pkj_updated_at' => $this->pkj_updated_at,
            'pkj_updated_by' => $this->pkj_updated_by,
            'pkj_deleted_at' => $this->pkj_deleted_at,
            'pkj_deleted_by' => $this->pkj_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pkj_nama', $this->pkj_nama]);

        return $dataProvider;
    }
}
