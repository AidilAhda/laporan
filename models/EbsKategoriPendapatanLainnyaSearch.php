<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsKategoriPendapatanLainnya;

/**
 * EbsKategoriPendapatanLainnyaSearch represents the model behind the search form of `app\models\EbsKategoriPendapatanLainnya`.
 */
class EbsKategoriPendapatanLainnyaSearch extends EbsKategoriPendapatanLainnya
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['katpen_id', 'katpen_aktif', 'katpen_created_by', 'katpen_updated_by', 'katpen_deleted_by'], 'integer'],
            [['katpen_nama', 'katpen_keterangan', 'katpen_created_at', 'katpen_updated_at', 'katpen_deleted_at'], 'safe'],
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
        $query = EbsKategoriPendapatanLainnya::find();

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
            'katpen_id' => $this->katpen_id,
            'katpen_aktif' => $this->katpen_aktif,
            'katpen_created_at' => $this->katpen_created_at,
            'katpen_created_by' => $this->katpen_created_by,
            'katpen_updated_at' => $this->katpen_updated_at,
            'katpen_updated_by' => $this->katpen_updated_by,
            'katpen_deleted_at' => $this->katpen_deleted_at,
            'katpen_deleted_by' => $this->katpen_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'katpen_nama', $this->katpen_nama])
            ->andFilterWhere(['like', 'katpen_keterangan', $this->katpen_keterangan]);

        return $dataProvider;
    }
}
