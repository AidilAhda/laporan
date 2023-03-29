<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsMKodePembayaran;

/**
 * EbsMKodePembayaranSearch represents the model behind the search form of `app\models\EbsMKodePembayaran`.
 */
class EbsMKodePembayaranSearch extends EbsMKodePembayaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kob_id', 'kob_aktif', 'kob_plafon', 'kob_created_by', 'kob_updated_by', 'kob_deleted_by'], 'integer'],
            [['kob_nama', 'kob_keterangan', 'kob_created_at', 'kob_updated_at', 'kob_deleted_at'], 'safe'],
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
        $query = EbsMKodePembayaran::find();

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
            'kob_id' => $this->kob_id,
            'kob_aktif' => $this->kob_aktif,
            'kob_plafon' => $this->kob_plafon,
            'kob_created_at' => $this->kob_created_at,
            'kob_created_by' => $this->kob_created_by,
            'kob_updated_at' => $this->kob_updated_at,
            'kob_updated_by' => $this->kob_updated_by,
            'kob_deleted_at' => $this->kob_deleted_at,
            'kob_deleted_by' => $this->kob_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'kob_nama', $this->kob_nama])
            ->andFilterWhere(['like', 'kob_keterangan', $this->kob_keterangan]);

        return $dataProvider;
    }
}
