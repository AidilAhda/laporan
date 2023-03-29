<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMJurusan;

/**
 * SdmMJurusanSearch represents the model behind the search form of `app\models\SdmMJurusan`.
 */
class SdmMJurusanSearch extends SdmMJurusan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jur_id', 'jur_pdd_kode', 'jur_aktif', 'jur_created_by', 'jur_updated_by', 'jur_deleted_by'], 'integer'],
            [['jur_kode', 'jur_nama', 'jur_created_at', 'jur_updated_at', 'jur_deleted_at'], 'safe'],
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
        $query = SdmMJurusan::find();

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
            'jur_id' => $this->jur_id,
            'jur_pdd_kode' => $this->jur_pdd_kode,
            'jur_aktif' => $this->jur_aktif,
            'jur_created_at' => $this->jur_created_at,
            'jur_created_by' => $this->jur_created_by,
            'jur_updated_at' => $this->jur_updated_at,
            'jur_updated_by' => $this->jur_updated_by,
            'jur_deleted_at' => $this->jur_deleted_at,
            'jur_deleted_by' => $this->jur_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'jur_kode', $this->jur_kode])
            ->andFilterWhere(['like', 'jur_nama', $this->jur_nama]);

        return $dataProvider;
    }
}
