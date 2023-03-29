<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsMLoketPembayaran;

/**
 * EbsMLoketPembayaranSearch represents the model behind the search form of `app\models\EbsMLoketPembayaran`.
 */
class EbsMLoketPembayaranSearch extends EbsMLoketPembayaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lob_id', 'lob_aktif', 'lob_created_by', 'lob_updated_by', 'lob_deleted_by'], 'integer'],
            [['lob_nama', 'lob_keterangan', 'lob_created_at', 'lob_updated_at', 'lob_deleted_at'], 'safe'],
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
        $query = EbsMLoketPembayaran::find();

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
            'lob_id' => $this->lob_id,
            'lob_aktif' => $this->lob_aktif,
            'lob_created_at' => $this->lob_created_at,
            'lob_created_by' => $this->lob_created_by,
            'lob_updated_at' => $this->lob_updated_at,
            'lob_updated_by' => $this->lob_updated_by,
            'lob_deleted_at' => $this->lob_deleted_at,
            'lob_deleted_by' => $this->lob_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'lob_nama', $this->lob_nama])
            ->andFilterWhere(['like', 'lob_keterangan', $this->lob_keterangan]);

        return $dataProvider;
    }
}
