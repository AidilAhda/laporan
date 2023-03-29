<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMPangkat;

/**
 * SdmMPangkatSearch represents the model behind the search form of `app\models\SdmMPangkat`.
 */
class SdmMPangkatSearch extends SdmMPangkat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['smp_id', 'smp_aktif', 'smp_created_by', 'smp_updated_by', 'smp_deleted_by'], 'integer'],
            [['smp_nama', 'smp_created_at', 'smp_updated_at', 'smp_deleted_at'], 'safe'],
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
        $query = SdmMPangkat::find();

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
            'smp_id' => $this->smp_id,
            'smp_aktif' => $this->smp_aktif,
            'smp_created_at' => $this->smp_created_at,
            'smp_created_by' => $this->smp_created_by,
            'smp_updated_at' => $this->smp_updated_at,
            'smp_updated_by' => $this->smp_updated_by,
            'smp_deleted_at' => $this->smp_deleted_at,
            'smp_deleted_by' => $this->smp_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'smp_nama', $this->smp_nama]);

        return $dataProvider;
    }
}
