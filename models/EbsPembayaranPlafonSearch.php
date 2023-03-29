<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsPembayaranPlafon;

/**
 * EbsPembayaranPlafonSearch represents the model behind the search form of `app\models\EbsPembayaranPlafon`.
 */
class EbsPembayaranPlafonSearch extends EbsPembayaranPlafon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['byp_kode', 'byp_pasien_kode', 'byp_reg_kode', 'byp_tanggal', 'byp_pmdd_kode', 'byp_tanggal_terima', 'byp_nama', 'byp_keterangan', 'byp_created_at', 'byp_updated_at', 'byp_deleted_at'], 'safe'],
            [['byp_kob_id', 'byp_lob_id', 'byp_shf_id', 'byp_created_by', 'byp_updated_by', 'byp_deleted_by'], 'integer'],
            [['byp_jumlah', 'byp_jumah_terima'], 'number'],
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
        $query = EbsPembayaranPlafon::find();

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
            'byp_tanggal' => $this->byp_tanggal,
            'byp_kob_id' => $this->byp_kob_id,
            'byp_jumlah' => $this->byp_jumlah,
            'byp_tanggal_terima' => $this->byp_tanggal_terima,
            'byp_jumah_terima' => $this->byp_jumah_terima,
            'byp_lob_id' => $this->byp_lob_id,
            'byp_shf_id' => $this->byp_shf_id,
            'byp_created_at' => $this->byp_created_at,
            'byp_created_by' => $this->byp_created_by,
            'byp_updated_at' => $this->byp_updated_at,
            'byp_updated_by' => $this->byp_updated_by,
            'byp_deleted_at' => $this->byp_deleted_at,
            'byp_deleted_by' => $this->byp_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'byp_kode', $this->byp_kode])
            ->andFilterWhere(['like', 'byp_pasien_kode', $this->byp_pasien_kode])
            ->andFilterWhere(['like', 'byp_reg_kode', $this->byp_reg_kode])
            ->andFilterWhere(['like', 'byp_pmdd_kode', $this->byp_pmdd_kode])
            ->andFilterWhere(['like', 'byp_nama', $this->byp_nama])
            ->andFilterWhere(['like', 'byp_keterangan', $this->byp_keterangan]);

        return $dataProvider;
    }
}
