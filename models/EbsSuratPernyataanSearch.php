<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsSuratPernyataan;

/**
 * EbsSuratPernyataanSearch represents the model behind the search form of `app\models\EbsSuratPernyataan`.
 */
class EbsSuratPernyataanSearch extends EbsSuratPernyataan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['snyt_id', 'snyt_status', 'snyt_created_by', 'snyt_updated_by', 'snyt_deleted_by'], 'integer'],
            [['snyt_pasien_kode', 'snyt_reg_kode', 'snyt_tanggal', 'snyt_nama_pasien', 'snyt_nama_penjamin', 'snyt_noidentitas_penjamin', 'snyt_nohp_penjamin', 'snyt_alamat_penjamin', 'snyt_hubungan_penjamin', 'snyt_jaminan', 'snyt_tgl_jatuhtempo', 'snyt_keterangan', 'snyt_created_at', 'snyt_updated_at', 'snyt_deleted_at'], 'safe'],
            [['snyt_jumlah_pembayaran'], 'number'],
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
        $query = EbsSuratPernyataan::find();

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
            'snyt_id' => $this->snyt_id,
            'snyt_tanggal' => $this->snyt_tanggal,
            'snyt_jumlah_pembayaran' => $this->snyt_jumlah_pembayaran,
            'snyt_tgl_jatuhtempo' => $this->snyt_tgl_jatuhtempo,
            'snyt_status' => $this->snyt_status,
            'snyt_created_at' => $this->snyt_created_at,
            'snyt_created_by' => $this->snyt_created_by,
            'snyt_updated_at' => $this->snyt_updated_at,
            'snyt_updated_by' => $this->snyt_updated_by,
            'snyt_deleted_at' => $this->snyt_deleted_at,
            'snyt_deleted_by' => $this->snyt_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'snyt_pasien_kode', $this->snyt_pasien_kode])
            ->andFilterWhere(['like', 'snyt_reg_kode', $this->snyt_reg_kode])
            ->andFilterWhere(['like', 'snyt_nama_pasien', $this->snyt_nama_pasien])
            ->andFilterWhere(['like', 'snyt_nama_penjamin', $this->snyt_nama_penjamin])
            ->andFilterWhere(['like', 'snyt_noidentitas_penjamin', $this->snyt_noidentitas_penjamin])
            ->andFilterWhere(['like', 'snyt_nohp_penjamin', $this->snyt_nohp_penjamin])
            ->andFilterWhere(['like', 'snyt_alamat_penjamin', $this->snyt_alamat_penjamin])
            ->andFilterWhere(['like', 'snyt_hubungan_penjamin', $this->snyt_hubungan_penjamin])
            ->andFilterWhere(['like', 'snyt_jaminan', $this->snyt_jaminan])
            ->andFilterWhere(['like', 'snyt_keterangan', $this->snyt_keterangan]);

        return $dataProvider;
    }
}
